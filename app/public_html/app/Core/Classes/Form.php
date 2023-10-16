<?php

namespace core\classes;
class Form
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createForm($form_data)
    {
        $query = "INSERT INTO forms (meta) VALUES (:meta)";
        $this->db->query($query, ['meta' => json_encode($form_data)]);
    }

    public function getForm($form_id)
    {
        $query = "SELECT meta FROM forms WHERE id = :id";
        $stmt = $this->db->query($query, ['id' => $form_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
