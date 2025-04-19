<?php
ob_start();
session_start();
header('Content-Type: application/json');
require_once '../db_connect.php';
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    ob_end_flush();
    exit;
}

$action = $input['action'] ?? '';
$user_id = isset($input['user_id']) ? (int)$input['user_id'] : 0;

if (!$action || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'Action and user_id are required']);
    ob_end_flush();
    exit;
}

// Check session
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
    error_log("Session expired or user_id not set for user_id: $user_id");
    echo json_encode(['success' => false, 'message' => 'Session expired, please log in']);
    ob_end_flush();
    exit;
}

if ($user_id != $_SESSION['user_id']) {
    error_log("Unauthorized access attempt: input user_id $user_id does not match session user_id {$_SESSION['user_id']}");
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    ob_end_flush();
    exit;
}

try {
    switch ($action) {
        case 'get_profile':
            $stmt = $pdo->prepare('
                SELECT fname, mname, lname, address, date_of_birth, sex, civil_status,
                       nationality, place_of_birth, contact_number, email_address
                FROM profiles
                WHERE user_id = ?
            ');
            $stmt->execute([$user_id]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($profile) {
                echo json_encode(['success' => true, 'data' => $profile]);
            } else {
                echo json_encode(['success' => true, 'data' => null, 'message' => 'No profile found']);
            }
            break;

        case 'get_appointments':
            $stmt = $pdo->prepare('
                SELECT id, fname, mname, lname, address, date_of_birth, sex, civil_status, nationality,
                       place_of_birth, contact_number, email_address, pet_id, pet_name, appointment_date,
                       appointment_time, purpose, status
                FROM appointments
                WHERE user_id = ?
                ORDER BY appointment_date DESC, appointment_time DESC
            ');
            $stmt->execute([$user_id]);
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $appointments]);
            break;

        case 'save_appointment':
        case 'edit_appointment':
            $appointment_id = $action === 'edit_appointment' ? (int)($input['appointment_id'] ?? 0) : 0;
            $fname = trim($input['fname'] ?? '');
            $mname = trim($input['mname'] ?? '');
            $lname = trim($input['lname'] ?? '');
            $address = trim($input['address'] ?? '');
            $date_of_birth = $input['date_of_birth'] ?? null;
            $sex = $input['sex'] ?? null;
            $civil_status = $input['civil_status'] ?? null;
            $nationality = trim($input['nationality'] ?? '');
            $place_of_birth = trim($input['place_of_birth'] ?? '');
            $contact_number = trim($input['contact_number'] ?? '');
            $email_address = trim($input['email_address'] ?? '');
            $pet_id = !empty($input['pet_id']) ? (int)$input['pet_id'] : null;
            $pet_name = trim($input['pet_name'] ?? '');
            $appointment_date = $input['appointment_date'] ?? '';
            $appointment_time = $input['appointment_time'] ?? '';
            $purpose = trim($input['purpose'] ?? '');
            $terms_accepted = filter_var($input['terms_accepted'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $status = $action === 'edit_appointment' ? ($input['status'] ?? 'Pending') : 'Pending';

            // Log input for debugging
            error_log("$action input: " . json_encode([
                'user_id' => $user_id,
                'appointment_id' => $appointment_id,
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname,
                'pet_id' => $pet_id,
                'pet_name' => $pet_name,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time,
                'purpose' => $purpose,
                'terms_accepted' => $terms_accepted
            ]));

            // Validation
            if (empty($fname) || empty($lname) || empty($pet_id) || empty($pet_name) ||
                empty($appointment_date) || empty($appointment_time) || empty($purpose)) {
                echo json_encode(['success' => false, 'message' => 'Required fields are missing', 'missing' => compact('fname', 'lname', 'pet_id', 'pet_name', 'appointment_date', 'appointment_time', 'purpose')]);
                ob_end_flush();
                exit;
            }

            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $appointment_date)) {
                echo json_encode(['success' => false, 'message' => 'Invalid appointment date format']);
                ob_end_flush();
                exit;
            }

            if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $appointment_time)) {
                echo json_encode(['success' => false, 'message' => 'Invalid appointment time format']);
                ob_end_flush();
                exit;
            }

            if ($email_address && !filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email address format']);
                ob_end_flush();
                exit;
            }

            $today = date('Y-m-d');
            $now = new DateTime();
            $selectedDateTime = new DateTime("$appointment_date $appointment_time");

            if ($appointment_date < $today) {
                echo json_encode(['success' => false, 'message' => 'Appointment date cannot be in the past']);
                ob_end_flush();
                exit;
            }

            if ($appointment_date === $today && $selectedDateTime < $now) {
                echo json_encode(['success' => false, 'message' => 'Appointment time cannot be in the past']);
                ob_end_flush();
                exit;
            }

            if (strlen($purpose) > 255) {
                echo json_encode(['success' => false, 'message' => 'Purpose cannot exceed 255 characters']);
                ob_end_flush();
                exit;
            }

            if (!$terms_accepted) {
                echo json_encode(['success' => false, 'message' => 'Terms and Conditions must be accepted']);
                ob_end_flush();
                exit;
            }

            // Validate pet_id and fetch pet_name
            $stmt = $pdo->prepare("SELECT pet_name FROM pet_records WHERE id = ? AND user_id = ?");
            $stmt->execute([$pet_id, $user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                echo json_encode(['success' => false, 'message' => 'Invalid pet ID']);
                ob_end_flush();
                exit;
            }
            $pet_name = $row['pet_name'];

            if ($action === 'edit_appointment') {
                if ($appointment_id <= 0) {
                    echo json_encode(['success' => false, 'message' => 'Invalid appointment ID']);
                    ob_end_flush();
                    exit;
                }

                // Verify appointment ownership
                $stmt = $pdo->prepare("SELECT user_id FROM appointments WHERE id = ?");
                $stmt->execute([$appointment_id]);
                if ($stmt->fetchColumn() != $user_id) {
                    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                    ob_end_flush();
                    exit;
                }

                $query = "
                    UPDATE appointments SET
                        fname = ?, mname = ?, lname = ?, address = ?, date_of_birth = ?,
                        sex = ?, civil_status = ?, nationality = ?, place_of_birth = ?,
                        contact_number = ?, email_address = ?, pet_id = ?, pet_name = ?,
                        appointment_date = ?, appointment_time = ?, purpose = ?, terms_accepted = ?,
                        status = ?
                    WHERE id = ? AND user_id = ?
                ";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    $fname, $mname, $lname, $address, $date_of_birth ?: null,
                    $sex, $civil_status, $nationality, $place_of_birth,
                    $contact_number, $email_address, $pet_id, $pet_name,
                    $appointment_date, $appointment_time, $purpose, $terms_accepted,
                    $status, $appointment_id, $user_id
                ]);
                echo json_encode(['success' => true, 'message' => 'Appointment updated successfully']);
            } else {
                $query = "
                    INSERT INTO appointments (
                        user_id, fname, mname, lname, address, date_of_birth, sex, civil_status,
                        nationality, place_of_birth, contact_number, email_address, pet_id, pet_name,
                        appointment_date, appointment_time, purpose, terms_accepted, status
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    $user_id, $fname, $mname, $lname, $address, $date_of_birth ?: null,
                    $sex, $civil_status, $nationality, $place_of_birth,
                    $contact_number, $email_address, $pet_id, $pet_name,
                    $appointment_date, $appointment_time, $purpose, $terms_accepted,
                    $status
                ]);
                echo json_encode(['success' => true, 'message' => 'Appointment created successfully']);
            }
            break;

        case 'delete_appointment':
            $appointment_id = (int)($input['appointment_id'] ?? 0);
            if ($appointment_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid appointment ID']);
                ob_end_flush();
                exit;
            }

            // Verify ownership
            $stmt = $pdo->prepare("SELECT user_id FROM appointments WHERE id = ?");
            $stmt->execute([$appointment_id]);
            if ($stmt->fetchColumn() != $user_id) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
            $stmt->execute([$appointment_id, $user_id]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Appointment not found']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    $errorMessage = "Database error: " . $e->getMessage();
    error_log("Appointment error: " . $errorMessage);
    echo json_encode(['success' => false, 'message' => 'Database error occurred', 'debug' => $errorMessage]);
}
ob_end_flush();
?>