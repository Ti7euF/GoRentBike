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

    public function getAvailableBikes(int $offset, int $limit, string $filter, string $sort): array {
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT idBike, idStatusBike, brand, model, type, amortizationPrice, dailyPrice, totalKm, active, frame, gear, brakes, suspension, tires, seatpost
                FROM bike
                WHERE active = 1 AND idStatusBike = 1";
                
        if ($filter === 'mountain') {
            $sql .= " AND type = 'Montaña'";
        } elseif ($filter === 'road') {
            $sql .= " AND type = 'Carretera'";
        }

        if ($sort === 'asc') {
            $sql .= " ORDER BY dailyPrice ASC";
        } else {
            $sql .= " ORDER BY dailyPrice DESC";
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql);

        if (empty($result)) {
            return [];
        }

        $bikes = [];

        foreach ($result as $data) {
            $bikes[$data['idBike']] = new Bike($data);
        }

        return array_values($bikes);
    }

    public function countAvailableBikes(string $filter) {
        $sql = "SELECT COUNT(idBike) AS total
                FROM bike
                WHERE active = 1 AND idStatusBike = 1";
                
        if ($filter === 'mountain') {
            $sql .= " AND type = 'Montaña'";
        } elseif ($filter === 'road') {
            $sql .= " AND type = 'Carretera'";
        }

        $result = $this->db->query($sql);

        if (empty($result)) {
            return 0;
        }

        return (int) $result[0]['total'];
    }

    public function getBikesImagesByIds(array $idsBike): array
    {
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
}
