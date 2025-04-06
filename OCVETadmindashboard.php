<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: OCVETadmindb.php");
    exit;
}

// Get the logged-in username
$username = htmlspecialchars($_SESSION["username"]);

// Load the HTML template
$html_content = file_get_contents("OCVETadmindb.php");

// Replace the placeholder with the actual username
$html_content = str_replace("[Username]", $username, $html_content);

// Output the modified HTML
echo $html_content;
?>