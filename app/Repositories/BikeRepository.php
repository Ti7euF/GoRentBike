<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Bike;

class BikeRepository
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAvailableBikes(int $offset, int $limit, string $filter, string $sort, ?string $startDate = null, ?string $endDate = null): array {
        $limit = (int)$limit;
        $offset = (int)$offset;
        $params = [];

        $sql = "SELECT idBike, idStatusBike, brand, model, type, dailyPrice, active, frame, gear, brakes, suspension, tires, seatpost
                FROM bike
                WHERE active = 1 AND idStatusBike = 1";
                
        if ($filter === 'mountain') {
            $sql .= " AND type = 'Montaña'";
        } elseif ($filter === 'road') {
            $sql .= " AND type = 'Carretera'";
        }

        if ($startDate && $endDate) {
            $sql .= " AND NOT EXISTS (
                SELECT 1
                FROM reservation r
                WHERE r.idBike = bike.idBike
                AND r.idReservationStatus = :status
                AND r.startDate < :endDate
                AND r.endDate > :startDate
            )";

            $params['status'] = 1;
            $params['startDate'] = $startDate;
            $params['endDate'] = $endDate;
        }

        if ($sort === 'asc') {
            $sql .= " ORDER BY dailyPrice ASC";
        } else {
            $sql .= " ORDER BY dailyPrice DESC";
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return [];
        }

        $bikes = [];

        foreach ($result as $row) {
            $bike = new Bike(
                $row['idBike'],
                $row['idStatusBike'],
                $row['brand'],
                $row['model'],
                $row['type'],
                (bool)$row['active']
            );

            $bike->setDailyPrice($row['dailyPrice'] ?? null);
            $bike->setFrame($row['frame'] ?? null);
            $bike->setGear($row['gear'] ?? null);
            $bike->setBrakes($row['brakes'] ?? null);
            $bike->setSuspension($row['suspension'] ?? null);
            $bike->setTires($row['tires'] ?? null);
            $bike->setSeatpost($row['seatpost'] ?? null);

            $bikes[$row['idBike']] = $bike;
        }

        return $bikes;
    }

    public function countAvailableBikes(string $filter, ?string $startDate = null, ?string $endDate = null) {
        $params = [];
        
        $sql = "SELECT COUNT(idBike) AS total
                FROM bike
                WHERE active = 1 AND idStatusBike = 1";
                
        if ($filter === 'mountain') {
            $sql .= " AND type = 'Montaña'";
        } elseif ($filter === 'road') {
            $sql .= " AND type = 'Carretera'";
        }

        if ($startDate && $endDate) {
            $sql .= " AND NOT EXISTS (
                SELECT 1
                FROM reservation r
                WHERE r.idBike = bike.idBike
                AND r.idReservationStatus = :status
                AND r.startDate < :endDate
                AND r.endDate > :startDate
            )";

            $params['status'] = 1;
            $params['startDate'] = $startDate;
            $params['endDate'] = $endDate;
        }

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return 0;
        }

        return (int) $result[0]['total'];
    }

    public function getBikesImagesByIds(array $idsBike): array {
        if (empty($idsBike)) return [];

        $ids = implode(',', array_map('intval', $idsBike));

        $sql = "SELECT idBike, idImage, path, description, main
                FROM bike_image
                WHERE idBike IN ($ids)
                ORDER BY main ASC";

        $result = $this->db->query($sql);

        $images = [];

        foreach ($result as $data) {
            $images[$data['idBike']][] = [
                'id' => $data['idImage'],
                'path' => $data['path'],
                'description' => $data['description'],
                'main' => $data['main'],
            ];
        }

        return $images;
    }

    public function isBikeAvailable(int $bikeId, string $startDate, string $endDate): bool {
        $sql = "SELECT 1
                FROM reservation
                WHERE idBike = :bikeId AND idReservationStatus = :status AND startDate < :endDate AND endDate > :startDate
                LIMIT 1";

        $params = [
            'bikeId' => $bikeId,
            'status' => 1,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return true;
        }

        return false;
    }

    public function getBikesById(array $ids): array {
        $idsBike = implode(',', array_fill(0, count($ids), '?'));

        $sql = "SELECT b.idBike, idStatusBike, brand, model, type, dailyPrice, active, frame, gear, brakes, suspension, tires, seatpost, path
                FROM bike b
                LEFT JOIN bike_image bi ON bi.idBike = b.idBike
                WHERE b.idBike IN ($idsBike) AND bi.main = 1";

        $result = $this->db->query($sql, $ids);

        if (empty($result)) {
            return [];
        }

        $bikes = [];

        foreach ($result as $row) {
            $bike = new Bike(
                $row['idBike'],
                $row['idStatusBike'],
                $row['brand'],
                $row['model'],
                $row['type'],
                (bool)$row['active']
            );

            $bike->setDailyPrice($row['dailyPrice'] ?? null);
            $bike->setFrame($row['frame'] ?? null);
            $bike->setGear($row['gear'] ?? null);
            $bike->setBrakes($row['brakes'] ?? null);
            $bike->setSuspension($row['suspension'] ?? null);
            $bike->setTires($row['tires'] ?? null);
            $bike->setSeatpost($row['seatpost'] ?? null);
            $bike->setPath($row['path'] ?? null);

            $bikes[$row['idBike']] = $bike;
        }

        return $bikes;
    }

    public function getBikeById(int $id): ?Bike {
        $sql = "SELECT b.idBike, idStatusBike, brand, model, type, dailyPrice, active, frame, gear, brakes, suspension, tires, seatpost, path
                FROM bike b
                LEFT JOIN bike_image bi ON bi.idBike = b.idBike
                WHERE b.idBike = ? AND bi.main = 1";

        $result = $this->db->query($sql, [$id]);

        if (empty($result)) {
            return null;
        }

        $row = $result[0];

        $bike = new Bike(
            $row['idBike'],
            $row['idStatusBike'],
            $row['brand'],
            $row['model'],
            $row['type'],
            (bool)$row['active']
        );

        $bike->setDailyPrice($row['dailyPrice'] ?? null);
        $bike->setFrame($row['frame'] ?? null);
        $bike->setGear($row['gear'] ?? null);
        $bike->setBrakes($row['brakes'] ?? null);
        $bike->setSuspension($row['suspension'] ?? null);
        $bike->setTires($row['tires'] ?? null);
        $bike->setSeatpost($row['seatpost'] ?? null);
        $bike->setPath($row['path'] ?? null);

        return $bike;
    }


}
