<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security in production

try {
    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=ocvet_db', 'your_username', 'your_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user_id from query parameter
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        exit;
    }

    // Query to fetch user and profile data
    $stmt = $pdo->prepare('
        SELECT u.user_id, u.email, p.name, p.contact, p.address
        FROM user u
        LEFT JOIN profile p ON u.user_id = p.user_id
        WHERE u.user_id = :user_id
    ');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }

    // Prepare response data
    $data = [
        'email' => $user['email'],
        'name' => $user['name'] ?? 'N/A',
        'contact' => $user['contact'] ?? 'N/A',
        'address' => $user['address'] ?? 'N/A'
    ];

    echo json_encode(['success' => true, 'data' => $data]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>