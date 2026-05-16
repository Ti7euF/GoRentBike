<?php
namespace App\Services;

class Database {
    private $pdo;

    public function __construct() {
        try {    
            $this->pdo = new \PDO("mysql:host=localhost;dbname=gorentbike", "root", "");

        } catch (\PDOException $e) {
            die('No se pudo conectar a la base de datos.');
        }
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            return [];
        }
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);

        } catch (\PDOException $e) {
            return false;
        }
    }
}
