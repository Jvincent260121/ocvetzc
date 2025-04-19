<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ocvet_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Other constants
define('MIN_PASSWORD_LENGTH', 8);
define('API_RESPONSE_SUCCESS', ['success' => true]);
define('API_RESPONSE_ERROR', ['success' => false, 'error' => '']);
?>