<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Bike;

class BikeRepository
{
    protected $db;

    public function __construct(Database $db) {
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
                AND r.startDate <= :endDate
                AND r.endDate >= :startDate
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

    public function isBikeAvailable(int $bikeId, ?string $startDate, ?string $endDate): bool {
        $sql = "SELECT 1
                FROM reservation
                WHERE idBike = :bikeId AND idReservationStatus = :status";

        $params = [
            'bikeId' => $bikeId,
            'status' => 1
        ];

        if ($startDate !== null && $endDate !== null) {
            $sql .= " AND startDate <= :endDate AND endDate >= :startDate";

            $params['startDate'] = $startDate;
            $params['endDate'] = $endDate;
        }

        $sql .= " LIMIT 1";

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
                WHERE b.idBike IN ($idsBike)
                GROUP BY b.idBike";
                //WHERE b.idBike IN ($idsBike) AND bi.main = 1";

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
        $sql = "SELECT b.idBike, idStatusBike, brand, model, type, dailyPrice, totalKm, active, frame, gear, brakes, suspension, tires, seatpost, path
                FROM bike b
                LEFT JOIN bike_image bi ON bi.idBike = b.idBike
                WHERE b.idBike = ?
                GROUP BY b.idBike";
                //WHERE b.idBike = ? AND bi.main = 1";

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
        $bike->setTotalKm($row['totalKm'] ?? null);
        $bike->setFrame($row['frame'] ?? null);
        $bike->setGear($row['gear'] ?? null);
        $bike->setBrakes($row['brakes'] ?? null);
        $bike->setSuspension($row['suspension'] ?? null);
        $bike->setTires($row['tires'] ?? null);
        $bike->setSeatpost($row['seatpost'] ?? null);
        $bike->setPath($row['path'] ?? null);

        return $bike;
    }

    
    public function getKmBikeById(int $idBike): ?int {
        $sql = "SELECT totalKm FROM bike WHERE idBike = :idBike";
        $params = ['idBike' => $idBike];

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return null;
        }

        return (float)$result[0]['totalKm'];
    }
    
    public function updateKmBike(int $idBike, float $km): ?int {
        $sql = "UPDATE bike SET totalKm = :km WHERE idBike = :idBike";
        $params = ['km' => $km, 'idBike' => $idBike];

        return $this->db->execute($sql, $params);
    }


    public function getBikesAmortization(int $offset, int $limit, string $filter, string $sort): array {
        $limit = (int)$limit;
        $offset = (int)$offset;
        $params = [];

        $sql = "SELECT b.idBike, b.idStatusBike, b.brand, b.model, b.type, (b.amortizationPrice + IFNULL(SUM(m.cost), 0) - IFNULL(SUM(rs.price), 0) - IFNULL(SUM(r.penalty), 0)) AS amortizationPrice, b.totalKm, b.active, bs.nameStatus
                FROM bike b
                LEFT JOIN bike_status bs ON bs.idStatus = b.idStatusBike
                LEFT JOIN reservation rs ON rs.idBike = b.idBike AND rs.idReservationStatus = 3
                LEFT JOIN rental r ON r.idReservation = rs.idReservation
                LEFT JOIN maintenance m ON m.idBike = b.idBike
                WHERE 1 = 1";
                
        if ($filter != 'all') {
            $sql .= " AND (b.brand LIKE :filter OR b.model LIKE :filter)";
            $params['filter'] = "%$filter%";
        }

        $sql .= " GROUP BY b.idBike, b.brand, b.model, b.type, b.totalKm, b.amortizationPrice";

        if ($sort === 'asc') {
            $sql .= " ORDER BY b.idBike ASC";
        } else {
            $sql .= " ORDER BY b.idBike DESC";
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

            $bike->setAmortizationPrice($row['amortizationPrice'] ?? null);
            $bike->setTotalKm($row['totalKm']);
            $bike->setBikeStatus($row['nameStatus']);

            $bikes[$row['idBike']] = $bike;
        }

        return $bikes;
    }

    public function countAmortizationBikes(string $filter) {
        $params = [];
        
        $sql = "SELECT COUNT(idBike) AS total
                FROM bike
                WHERE 1 = 1";
                
        if ($filter != 'all') {
            $sql .= " AND (brand LIKE :filter OR model LIKE :filter)";
            $params['filter'] = "%$filter%";
        }

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return 0;
        }

        return (int) $result[0]['total'];
    }


    public function updateBike(Bike $bike) {
        $sql = "UPDATE bike 
                SET idStatusBike = :idStatusBike, brand = :brand, model = :model, type = :type, dailyPrice = :dailyPrice, active = :active, 
                    frame = :frame, gear = :gear, brakes = :brakes, suspension = :suspension, tires = :tires, seatpost = :seatpost
                WHERE idBike = :idBike";

        $params = ['idBike' => $bike->getIdBike(), 'idStatusBike' => $bike->getIdStatusBike(), 'brand' => $bike->getBrand(), 'model' => $bike->getModel(), 'type' => $bike->getType(), 
                    'dailyPrice' => $bike->getDailyPrice(), 'active' => $bike->isActive() ? 1 : 0, 'frame' => $bike->getFrame(), 'gear' => $bike->getGear(), 'brakes' => $bike->getBrakes(), 
                    'suspension' => $bike->getSuspension(),'tires' => $bike->getTires(), 'seatpost' => $bike->getSeatpost()
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function addImageToBike(int $idBike, string $path, string $description): bool {
        $sql = "INSERT INTO bike_image (idBike, path, description, main)
                VALUES (:idBike, :path, :description, 1)";

        $params = [
            'idBike' => $idBike,
            'path' => $path,
            'description' => $description
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function deleteImageToBike(int $idBike, string $path): bool {
        $sql = "DELETE FROM bike_image
                WHERE idBike = :idBike AND path = :path";

        $params = [
            'idBike' => $idBike,
            'path' => $path
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }


    public function addBike(Bike $bike) {
        $sql = "INSERT INTO bike (idStatusBike, brand, model, type, amortizationPrice, dailyPrice, totalKm, active, frame, gear, brakes, suspension, tires, seatpost)
                VALUES (:idStatusBike, :brand, :model, :type, :amortizationPrice, :dailyPrice, :totalKm, :active, :frame, :gear, :brakes, :suspension, :tires, :seatpost)";

        $params = ['idStatusBike' => $bike->getIdStatusBike(), 'brand' => $bike->getBrand(), 'model' => $bike->getModel(), 'type' => $bike->getType(), 'amortizationPrice' => $bike->getAmortizationPrice(), 
                    'dailyPrice' => $bike->getDailyPrice(), 'totalKm' => $bike->getTotalKm(), 'active' => $bike->isActive() ? 1 : 0, 'frame' => $bike->getFrame(), 'gear' => $bike->getGear(), 
                    'brakes' => $bike->getBrakes(), 'suspension' => $bike->getSuspension(),'tires' => $bike->getTires(), 'seatpost' => $bike->getSeatpost()
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function updateBikeStatus(int $idBike, int $idStatusBike): bool {
        $sql = "UPDATE bike
                SET idStatusBike = :idStatusBike
                WHERE idBike = :idBike";

        $params = [
            'idBike' => $idBike,
            'idStatusBike' => $idStatusBike
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }
}
