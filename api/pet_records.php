<?php
ob_start();
header('Content-Type: application/json');
require_once '../db_connect.php';
require_once '../config.php';

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Log input for debugging
error_log('Pet records input: ' . print_r($input, true));

// Validate JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    ob_end_flush();
    exit;
}

// Check action and user_id
$action = isset($input['action']) ? $input['action'] : '';
$user_id = isset($input['user_id']) ? (int)$input['user_id'] : 0;

if (!$action || !$user_id) {
    echo json_encode(['success' => false, 'error' => 'Action and user_id are required']);
    ob_end_flush();
    exit;
}

// Verify user exists
$stmt = $pdo->prepare('SELECT id FROM users WHERE id = ?');
$stmt->execute([$user_id]);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    ob_end_flush();
    exit;
}

try {
    switch ($action) {
        case 'get_pet_records':
            $stmt = $pdo->prepare('SELECT id, pet_name, species, breed, sex, age, color_markings FROM pet_records WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $records]);
            break;

        case 'save_pet_record':
            $pet_name = isset($input['pet_name']) ? trim($input['pet_name']) : '';
            $species = isset($input['species']) ? trim($input['species']) : '';
            $breed = isset($input['breed']) ? trim($input['breed']) : '';
            $sex = isset($input['sex']) ? trim($input['sex']) : '';
            $age = isset($input['age']) ? (int)$input['age'] : 0;
            $color_markings = isset($input['color_markings']) ? trim($input['color_markings']) : '';

            // Validate required fields
            if (empty($pet_name) || empty($species) || empty($sex) || $age <= 0) {
                echo json_encode(['success' => false, 'error' => 'Pet name, species, sex, and age are required']);
                ob_end_flush();
                exit;
            }

            // Validate sex
            if (!in_array($sex, ['Male', 'Female', 'Unknown'])) {
                echo json_encode(['success' => false, 'error' => 'Invalid sex value']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare('INSERT INTO pet_records (user_id, pet_name, species, breed, sex, age, color_markings) VALUES (?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$user_id, $pet_name, $species, $breed, $sex, $age, $color_markings])) {
                echo json_encode(['success' => true, 'message' => 'Pet record saved successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to save pet record']);
            }
            break;

        case 'update_pet_record':
            $pet_id = isset($input['pet_id']) ? (int)$input['pet_id'] : 0;
            $pet_name = isset($input['pet_name']) ? trim($input['pet_name']) : '';
            $species = isset($input['species']) ? trim($input['species']) : '';
            $breed = isset($input['breed']) ? trim($input['breed']) : '';
            $sex = isset($input['sex']) ? trim($input['sex']) : '';
            $age = isset($input['age']) ? (int)$input['age'] : 0;
            $color_markings = isset($input['color_markings']) ? trim($input['color_markings']) : '';

            // Validate required fields
            if (!$pet_id || empty($pet_name) || empty($species) || empty($sex) || $age <= 0) {
                echo json_encode(['success' => false, 'error' => 'Pet ID, name, species, sex, and age are required']);
                ob_end_flush();
                exit;
            }

            // Validate sex
            if (!in_array($sex, ['Male', 'Female', 'Unknown'])) {
                echo json_encode(['success' => false, 'error' => 'Invalid sex value']);
                ob_end_flush();
                exit;
            }

            // Verify pet record belongs to user
            $stmt = $pdo->prepare('SELECT id FROM pet_records WHERE id = ? AND user_id = ?');
            $stmt->execute([$pet_id, $user_id]);
            if (!$stmt->fetch()) {
                echo json_encode(['success' => false, 'error' => 'Pet record not found or unauthorized']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare('UPDATE pet_records SET pet_name = ?, species = ?, breed = ?, sex = ?, age = ?, color_markings = ? WHERE id = ? AND user_id = ?');
            if ($stmt->execute([$pet_name, $species, $breed, $sex, $age, $color_markings, $pet_id, $user_id])) {
                echo json_encode(['success' => true, 'message' => 'Pet record updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update pet record']);
            }
            break;

        case 'delete_pet_record':
            $pet_id = isset($input['pet_id']) ? (int)$input['pet_id'] : 0;
            if (!$pet_id) {
                echo json_encode(['success' => false, 'error' => 'Pet ID is required']);
                ob_end_flush();
                exit;
            }

            // Verify pet record belongs to user
            $stmt = $pdo->prepare('SELECT id FROM pet_records WHERE id = ? AND user_id = ?');
            $stmt->execute([$pet_id, $user_id]);
            if (!$stmt->fetch()) {
                echo json_encode(['success' => false, 'error' => 'Pet record not found or unauthorized']);
                ob_end_flush();
                exit;
            }

            $stmt = $pdo->prepare('DELETE FROM pet_records WHERE id = ? AND user_id = ?');
            if ($stmt->execute([$pet_id, $user_id])) {
                echo json_encode(['success' => true, 'message' => 'Pet record deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete pet record']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    error_log("Pet records error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}

ob_end_flush();
?>