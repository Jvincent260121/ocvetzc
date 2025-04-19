<?php
header('Content-Type: application/json');
ob_clean(); // Clear any previous output
try {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['action'] === 'get_user' && !empty($data['user_id'])) {
        $pdo = new PDO('mysql:host=localhost;dbname=ocvet_db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
        $stmt->execute([$data['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user ? ['success' => true, 'username' => $user['username']] : ['success' => false, 'error' => 'User not found']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
}
?>