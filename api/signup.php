<?php
ob_start();
header('Content-Type: application/json');
require_once '../db_connect.php';
require_once '../config.php';

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate JSON decoding
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    ob_end_flush();
    exit;
}

$username = isset($input['username']) ? trim($input['username']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$password = isset($input['password']) ? trim($input['password']) : '';

// Validate input
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    ob_end_flush();
    exit;
}

if (strlen($password) < MIN_PASSWORD_LENGTH) {
    echo json_encode(['success' => false, 'error' => 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters']);
    ob_end_flush();
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email format']);
    ob_end_flush();
    exit;
}

if (strlen($username) > 50 || strlen($email) > 100) {
    echo json_encode(['success' => false, 'error' => 'Username or email too long']);
    ob_end_flush();
    exit;
}

// Check for duplicates
try {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'error' => 'Username or email already exists']);
        ob_end_flush();
        exit;
    }

    // Hash password and insert user
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $email, $password_hash])) {
        // Get the newly created user_id
        $user_id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'user_id' => $user_id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to create account']);
    }
} catch (PDOException $e) {
    error_log("Signup error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'An error occurred during signup']);
}

ob_end_flush();
?>