<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Reservation;

class ReservationRepository
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createReservation(Reservation $reservation): bool {
        $sql = "INSERT INTO reservation (idUser, idBike, startDate, endDate, price, idReservationStatus) 
                VALUES (:userId, :bikeId, :startDate, :endDate, :price, :idReservationStatus)";

        $params = [
            'userId' => $reservation->getIdUser(),    
            'bikeId' => $reservation->getIdBike(),
            'startDate' => $reservation->getStartDate(),
            'endDate' => $reservation->getEndDate(),
            'price' => $reservation->getPrice(),
            'idReservationStatus' => $reservation->getIdReservationStatus(),
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }
}