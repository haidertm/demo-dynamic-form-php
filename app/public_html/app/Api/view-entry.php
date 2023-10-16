<?php

use core\classes\Form;

$db = new Database();
$form = new Form($db);

$form_id = $_GET['id'];
$form_meta = $form->getForm($form_id);

echo json_encode($form_meta);
