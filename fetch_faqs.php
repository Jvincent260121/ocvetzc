<?php
header('Content-Type: application/json'); // Set the response type to JSON

// Fetch and decode the FAQs from the JSON file
$faqs = json_decode(file_get_contents("faqs.json"), true) ?: [];

// Output the FAQs as JSON
echo json_encode($faqs);
?>