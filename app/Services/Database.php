<?php
namespace App\Services;

class Database {
    private $pdo;

    public function __construct() {
        try {
            $host = getenv('DB_HOST');
            $dbname = getenv('DB_DATABASE');
            $user = getenv('DB_USERNAME');
            $pass = getenv('DB_PASSWORD');

            $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

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
