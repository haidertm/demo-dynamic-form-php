<?php

namespace Haider\Demo\core\classes;

use PDO;

class Database {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAssoc($query, $params = []) {
        $stmt = $this->query($query, $params = []);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPDO() {
        return $this->pdo;
    }
}

