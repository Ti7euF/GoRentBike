<?php
namespace App\Services;

class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = new \PDO(
            "mysql:host=localhost;dbname=gorentbike",
            "root",
            ""
        );
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
