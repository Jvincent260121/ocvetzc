<?php
ob_start();
header('Content-Type: application/json');
require_once '../db_connect.php';
require_once '../config.php';

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    ob_end_flush();
    exit;
}

// Check action
$action = isset($input['action']) ? $input['action'] : '';
$user_id = isset($input['user_id']) ? (int)$input['user_id'] : 0;

if (!$action || !$user_id) {
    echo json_encode(['success' => false, 'error' => 'Action and user_id are required']);
    ob_end_flush();
    exit;
}

try {
    switch ($action) {
        case 'get_profile':
            $stmt = $pdo->prepare('SELECT fname, mname, lname, address, date_of_birth, sex, civil_status, nationality, place_of_birth, contact_number, email_address FROM profiles WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $profile = $stmt->fetch();

            if ($profile) {
                echo json_encode(['success' => true, 'data' => $profile]);
            } else {
                echo json_encode(['success' => true, 'data' => null, 'message' => 'No profile found']);
            }
            break;

        case 'save_profile':
            $fname = isset($input['fname']) ? trim($input['fname']) : '';
            $mname = isset($input['mname']) ? trim($input['mname']) : '';
            $lname = isset($input['lname']) ? trim($input['lname']) : '';
            $address = isset($input['address']) ? trim($input['address']) : '';
            $date_of_birth = isset($input['date_of_birth']) ? trim($input['date_of_birth']) : null;
            $sex = isset($input['sex']) ? trim($input['sex']) : null;
            $civil_status = isset($input['civil_status']) ? trim($input['civil_status']) : null;
            $nationality = isset($input['nationality']) ? trim($input['nationality']) : '';
            $place_of_birth = isset($input['place_of_birth']) ? trim($input['place_of_birth']) : '';
            $contact_number = isset($input['contact_number']) ? trim($input['contact_number']) : '';
            $email_address = isset($input['email_address']) ? trim($input['email_address']) : '';

            if (empty($fname) || empty($lname)) {
                echo json_encode(['success' => false, 'error' => 'First name and last name are required']);
                ob_end_flush();
                exit;
            }

            // Validate email format if provided
            if (!empty($email_address) && !filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'error' => 'Invalid email address format']);
                ob_end_flush();
                exit;
            }

            // Check if profile already exists
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM profiles WHERE user_id = ?');
            $stmt->execute([$user_id]);
            if ($stmt->fetchColumn() > 0) {
                echo json_encode(['success' => false, 'error' => 'Profile already exists']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare('INSERT INTO profiles (user_id, fname, mname, lname, address, date_of_birth, sex, civil_status, nationality, place_of_birth, contact_number, email_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$user_id, $fname, $mname, $lname, $address, $date_of_birth, $sex, $civil_status, $nationality, $place_of_birth, $contact_number, $email_address])) {
                echo json_encode(['success' => true, 'message' => 'Profile saved successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to save profile']);
            }
            break;

        case 'update_profile':
            $fname = isset($input['fname']) ? trim($input['fname']) : '';
            $mname = isset($input['mname']) ? trim($input['mname']) : '';
            $lname = isset($input['lname']) ? trim($input['lname']) : '';
            $address = isset($input['address']) ? trim($input['address']) : '';
            $date_of_birth = isset($input['date_of_birth']) ? trim($input['date_of_birth']) : null;
            $sex = isset($input['sex']) ? trim($input['sex']) : null;
            $civil_status = isset($input['civil_status']) ? trim($input['civil_status']) : null;
            $nationality = isset($input['nationality']) ? trim($input['nationality']) : '';
            $place_of_birth = isset($input['place_of_birth']) ? trim($input['place_of_birth']) : '';
            $contact_number = isset($input['contact_number']) ? trim($input['contact_number']) : '';
            $email_address = isset($input['email_address']) ? trim($input['email_address']) : '';

            if (empty($fname) || empty($lname)) {
                echo json_encode(['success' => false, 'error' => 'First name and last name are required']);
                ob_end_flush();
                exit;
            }

            // Validate email format if provided
            if (!empty($email_address) && !filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'error' => 'Invalid email address format']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare('UPDATE profiles SET fname = ?, mname = ?, lname = ?, address = ?, date_of_birth = ?, sex = ?, civil_status = ?, nationality = ?, place_of_birth = ?, contact_number = ?, email_address = ? WHERE user_id = ?');
            if ($stmt->execute([$fname, $mname, $lname, $address, $date_of_birth, $sex, $civil_status, $nationality, $place_of_birth, $contact_number, $email_address, $user_id])) {
                echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update profile']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    error_log("Profile error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error occurred']);
}

ob_end_flush();
?>