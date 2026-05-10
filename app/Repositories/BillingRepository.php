<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Billing;

class BillingRepository
{
    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getIncome(string $startDate, string $endDate): array {
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;

        $sql = "SELECT COALESCE(SUM(r.price), 0) AS reservationIncome, COALESCE(SUM(rt.penalty), 0) AS penaltiesIncome, COALESCE(SUM(r.price), 0) + COALESCE(SUM(rt.penalty), 0) AS incomeTotal
                FROM reservation r
                LEFT JOIN rental rt ON rt.idReservation = r.idReservation
                WHERE r.idReservationStatus = 3 AND r.startDate BETWEEN :startDate AND :endDate";

        $result = $this->db->query($sql, $params);
        
        $row = $result[0];

        return $row;
    }

    public function getExpenses(string $startDate, string $endDate): array {
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;

        $sql = "SELECT COALESCE(SUM(cost), 0) AS maintenanceExpenses
                FROM maintenance
                WHERE startDate BETWEEN :startDate AND :endDate";

        $result = $this->db->query($sql, $params);

        $row = $result[0];

        return $row;
    }

    public function getMovements(string $startDate, string $endDate, $sort): array {
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;

        $sql = "SELECT rs.startDate AS movementDate, 'Alquiler' AS movementType, 'Alquiler de bicicleta' AS concept, rs.price AS amount
                FROM reservation rs
                WHERE rs.idReservationStatus = 3 AND rs.startDate BETWEEN :startDate AND :endDate
                UNION ALL
                SELECT r.pickupDate AS movementDate, 'Penalización' AS movementType, r.incident AS concept, r.penalty AS amount
                FROM rental r
                WHERE r.pickupDate IS NOT NULL AND r.penalty > 0 AND r.pickupDate BETWEEN :startDate AND :endDate
                UNION ALL
                SELECT m.startDate AS movementDate, 'Mantenimiento' AS movementType, m.description AS concept, -m.cost AS amount
                FROM maintenance m
                WHERE 1 = 1 AND m.startDate BETWEEN :startDate AND :endDate";

        if ($sort === 'asc') {
            $sql .= " ORDER BY movementDate ASC";
        } else {
            $sql .= " ORDER BY movementDate DESC";
        }

        $result = $this->db->query($sql, $params);

        return $result;
    }

    public function getMonthlyBilling(string $startDate, string $endDate): array {
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;

        $sql = "SELECT DATE_FORMAT(r.startDate, '%Y-%m') AS month, COALESCE(SUM(r.price), 0) + COALESCE(SUM(rt.penalty), 0) AS income
                FROM reservation r
                LEFT JOIN rental rt ON rt.idReservation = r.idReservation
                WHERE r.idReservationStatus = 3 AND r.startDate BETWEEN :startDate AND :endDate
                GROUP BY month
                UNION ALL
                SELECT DATE_FORMAT(m.startDate, '%Y-%m') AS month, -COALESCE(SUM(m.cost), 0) AS income
                FROM maintenance m
                WHERE m.startDate BETWEEN :startDate AND :endDate
                GROUP BY month";

        $result = $this->db->query($sql, $params);

        return $result;
    }

}