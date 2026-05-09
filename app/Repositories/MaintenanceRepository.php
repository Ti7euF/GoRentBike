<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Maintenance;

class MaintenanceRepository
{
    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getMaintenance(int $offset, int $limit, string $filter, string $sort, ?int $idMaintenance): array {
        $limit = (int)$limit;
        $offset = (int)$offset;
        $params = [];

        $sql = "SELECT m.idMaintenance, m.idBike, m.idUser, m.startDate, m.endDate, m.description, m.cost, CONCAT(b.brand, ' ', b.model) AS bikeName, CONCAT(u.firstName, ' ', u.lastName) AS userName 
                FROM maintenance m
                LEFT JOIN bike b ON b.idBike = m.idBike
                LEFT JOIN user u ON u.idUser = m.idUser
                WHERE 1 = 1";
     
        if ($filter !== "all") {
            $sql .= " AND (u.firstName LIKE :filter OR u.lastName LIKE :filter OR b.brand LIKE :filter OR b.model LIKE :filter)";
            $params['filter'] = "%$filter%";
        }

        if ($sort === 'asc') {
            $sql .= " ORDER BY startDate ASC";
        } else {
            $sql .= " ORDER BY startDate DESC";
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return [];
        }

        $maintenances = [];

        foreach ($result as $row) {
            $maintenance = new Maintenance(
                $row['idMaintenance'],
                $row['idBike'],
                $row['idUser'],
                $row['startDate'],
                $row['bikeName'],
                $row['userName']
            );

            $maintenance->setEndDate($row['endDate'] ?? null);
            $maintenance->setDescription($row['description'] ?? null);
            $maintenance->setCost($row['cost'] ?? null);
            
            $maintenances[] = $maintenance;
        }

        return $maintenances;
    }

    public function countMaintenance(string $filter) {
        $params = [];

        $sql = "SELECT COUNT(*) AS total
                FROM maintenance m
                LEFT JOIN bike b ON b.idBike = m.idBike
                LEFT JOIN user u ON u.idUser = m.idUser
                WHERE 1 = 1";

        if ($filter !== "all") {
            $sql .= " AND (u.firstName LIKE :filter OR u.lastName LIKE :filter OR b.brand LIKE :filter OR b.model LIKE :filter)";
            $params['filter'] = "%$filter%";
        }

        $result = $this->db->query($sql, $params);

        return (int) $result[0]['total'];
    }

    public function addMaintenance(Maintenance $maintenance) {
        $sql = "INSERT INTO maintenance (idBike, idUser, startDate)
                VALUES (:idBike, :idUser, :startDate)";

        $params = [
            'idBike' => $maintenance->getIdBike(), 
            'idUser' => $maintenance->getIdUser(), 
            'startDate' => $maintenance->getStartDate()
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function getMaintenanceById(int $idMaintenance): ?Maintenance {
        $sql = "SELECT m.idMaintenance, m.idBike, m.idUser, m.startDate, m.endDate, m.description, m.cost, CONCAT(b.brand, ' ', b.model) AS bikeName, CONCAT(u.firstName, ' ', u.lastName) AS userName
                FROM maintenance m
                LEFT JOIN bike b ON b.idBike = m.idBike
                LEFT JOIN user u ON u.idUser = m.idUser
                WHERE m.idMaintenance = :idMaintenance
                LIMIT 1";

        $params = ['idMaintenance' => $idMaintenance];

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return null;
        }

        $row = $result[0];

        $maintenance = new Maintenance(
            $row['idMaintenance'],
            $row['idBike'],
            $row['idUser'],
            $row['startDate'],
            $row['bikeName'],
            $row['userName']
        );

        $maintenance->setEndDate($row['endDate'] ?? null);
        $maintenance->setDescription($row['description'] ?? null);
        $maintenance->setCost($row['cost'] ?? null);

        return $maintenance;
    }

    public function updateMaintenance(Maintenance $maintenance) {
        $sql = "UPDATE maintenance
                SET endDate = :endDate, description = :description, cost = :cost
                WHERE idMaintenance = :idMaintenance";

        $params = [
            'idMaintenance' => $maintenance->getIdMaintenance(), 
            'endDate' => $maintenance->getEndDate(), 
            'description' => $maintenance->getDescription(),
            'cost' => $maintenance->getCost()
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

}