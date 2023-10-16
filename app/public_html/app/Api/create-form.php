<?php

use core\classes\Form;

require_once __DIR__ . '/../Core/config.php';
require_once __DIR__ . '/../Core/Classes/Database.php';
require_once __DIR__ . '/../Core/Classes/Form.php';

// Instantiate Database and Form classes
$db = new Database();
$form = new Form($db);

// Assume the form data is sent as JSON in the request body
$form_data = json_decode(file_get_contents('php://input'), true);

print_r($form_data);

// Validate form data (you would add more robust validation here)
if (is_array($form_data)) {
    $form->createForm($form_data);
    echo json_encode(['status' => 'success']);
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid form data']);
}
