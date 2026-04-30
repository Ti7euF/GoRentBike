<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\Reservation;
use App\Models\Rental;

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

    public function getReservation(int $offset, int $limit, string $sort, int $idUser, string $filter): array {
        $limit = (int)$limit;
        $offset = (int)$offset;
        $params = [];

        $sql = "SELECT idReservation, r.idUser, firstName, lastName, r.idBike, brand, model, startDate, endDate, price, idReservationStatus, nameStatus AS reservationStatus
                FROM reservation r
                LEFT JOIN user u ON u.idUser = r.idUser
                LEFT JOIN bike b ON b.idBike = r.idBike
                LEFT JOIN reservation_status rs ON rs.idStatus = r.idReservationStatus
                WHERE 1 = 1";

        if ($idUser !== 0) {
            $sql .= " AND r.idUser = :idUser";
            $params['idUser'] = $idUser;
        }
                
        if ($filter !== "all") {
            $sql .= " AND nameStatus = :filter";
            $params['filter'] = $filter;
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

        $reservations = [];

        foreach ($result as $row) {
            $reservation = new Reservation(
                $row['idReservation'],
                $row['idUser'],
                $row['idBike'],
                $row['startDate'],
                $row['endDate'],
                $row['price'],
                $row['idReservationStatus']
            );

            $reservation->setFirstName($row['firstName'] ?? null);
            $reservation->setLastName($row['lastName'] ?? null);
            $reservation->setBrand($row['brand'] ?? null);
            $reservation->setModel($row['model'] ?? null);
            $reservation->setReservationStatus($row['reservationStatus'] ?? null);
            
            $reservations[] = $reservation;
        }

        return $reservations;
    }

    public function countReservation(int $idUser, string $filter) {
        $params = [];

        $sql = "SELECT COUNT(*) AS total
                FROM reservation r
                LEFT JOIN reservation_status rs ON rs.idStatus = r.idReservationStatus
                WHERE 1 = 1";

        if ($idUser !== 0) {
            $sql .= " AND idUser = :idUser";
            $params['idUser'] = $idUser;
        }

        if ($filter !== "all") {
            $sql .= " AND nameStatus = :filter";
            $params['filter'] = $filter;
        }

        $result = $this->db->query($sql, $params);

        return (int) $result[0]['total'];
    }

    //Usado para cancelar o confirmar la reserva
    public function updateReservationStatus(int $idReservation, int $idReservationStatus): bool {
        $sql = "UPDATE reservation
                SET idReservationStatus = :idReservationStatus
                WHERE idReservation = :idReservation";

        $params = [
            'idReservation' => $idReservation,
            'idReservationStatus' => $idReservationStatus
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function createRental(int $idReservation, string $pickupDate): bool {
        $sql = "INSERT INTO rental 
                (idReservation, pickupDate, returnDate, traveledKm, incident, penalty)
                VALUES (:idReservation, :pickupDate, NULL, 0, NULL, 0)";

        $params = [
            'idReservation' => $idReservation,
            'pickupDate' => $pickupDate
        ];

        $result = $this->db->execute($sql, $params);

        return $result;
    }

    public function updateRentalReturnDate(int $idReservation, string $returnDate): bool {
        $sql = "UPDATE rental
                SET returnDate = :returnDate
                WHERE idReservation = :idReservation";

        $params = [
            'returnDate' => $returnDate,
            'idReservation' => $idReservation
        ];

        return $this->db->execute($sql, $params);
    }

    public function updateFinishRental(int $idReservation, float $km, string $incident, float $penalty): bool {
        $sql = "UPDATE rental
                SET traveledKm = :km, incident = :incident, penalty = :penalty
                WHERE idReservation = :idReservation";

        $params = [
            'idReservation' => $idReservation,
            'km' => $km,
            'incident' => $incident,
            'penalty' => $penalty
        ];

        return $this->db->execute($sql, $params);
    }

    public function getReservationById($idReservation) {
        $sql = "SELECT * FROM reservation WHERE idReservation = :idReservation";
        $params = ['idReservation' => $idReservation];

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return null;
        }

        $row = $result[0];

        return new Reservation(
            $row['idReservation'],
            $row['idUser'],
            $row['idBike'],
            $row['startDate'],
            $row['endDate'],
            $row['price'],
            $row['idReservationStatus']
        );
    }

    public function getRentalByIdReservation($idReservation) {
        $sql = "SELECT * FROM rental WHERE idReservation = :idReservation";
        $params = ['idReservation' => $idReservation];

        $result = $this->db->query($sql, $params);

        if (empty($result)) {
            return null;
        }

        $row = $result[0];

        return new Rental(
            $row['idRental'],
            $row['idReservation'],
            $row['pickupDate'],
            $row['returnDate'],
            floatval($row['traveledKm']),
            $row['incident'],
            floatval($row['penalty'])
        );
    }
}