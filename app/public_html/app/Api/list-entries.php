<?php

use core\classes\Form;

require_once __DIR__ . '/../Core/config.php';
require_once __DIR__ . '/../Core/Classes/Database.php';
require_once __DIR__ . '/../Core/Classes/Form.php';

$db = new Database();
$form = new Form($db);

$query = "SELECT id, meta FROM forms";
$stmt = $db->query($query);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($entries);
