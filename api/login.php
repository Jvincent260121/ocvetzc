<?php
ob_start();
session_start(); // Ensure session is started
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

$username = isset($input['username']) ? trim($input['username']) : '';
$password = isset($input['password']) ? trim($input['password']) : '';

// Validate input
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Username and password are required']);
    ob_end_flush();
    exit;
}

// Check if username exists
try {
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
        ob_end_flush();
        exit;
    }

    // Verify password
    if (password_verify($password, $user['password_hash'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode([
            'success' => true,
            'user_id' => $user['id'],
            'username' => $user['username']
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
    }
} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'An error occurred during login']);
}

ob_end_flush();
?>