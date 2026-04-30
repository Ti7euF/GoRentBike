<?php

namespace App\Models;

class Rental
{
    private int $idRental;
    private int $idReservation;
    private string $pickupDate;
    private ?string $returnDate;
    private float $traveledKm;
    private ?string $incident;
    private float $penalty;

    public function __construct(
        int $idRental = 0,
        int $idReservation = 0,
        string $pickupDate = '',
        ?string $returnDate = null,
        float $traveledKm = 0.0,
        ?string $incident = null,
        float $penalty = 0.0
    ) {
        $this->idRental = $idRental;
        $this->idReservation = $idReservation;
        $this->pickupDate = $pickupDate;
        $this->returnDate = $returnDate;
        $this->traveledKm = $traveledKm;
        $this->incident = $incident;
        $this->penalty = $penalty;
    }

    public function getIdRental(): int {
        return $this->idRental;
    }
    public function setIdRental(int $idRental): void {
        $this->idRental = $idRental;
    }

    public function getIdReservation(): int {
        return $this->idReservation;
    }
    public function setIdReservation(int $idReservation): void {
        $this->idReservation = $idReservation;
    }

    public function getPickupDate(): string {
        return $this->pickupDate;
    }
    public function setPickupDate(string $pickupDate): void {
        $this->pickupDate = $pickupDate;
    }

    public function getReturnDate(): ?string {
        return $this->returnDate;
    }
    public function setReturnDate(?string $returnDate): void {
        $this->returnDate = $returnDate;
    }

    public function getTraveledKm(): float {
        return $this->traveledKm;
    }
    public function setTraveledKm(float $traveledKm): void {
        $this->traveledKm = $traveledKm;
    }

    public function getIncident(): ?string {
        return $this->incident;
    }
    public function setIncident(?string $incident): void {
        $this->incident = $incident;
    }

    public function getPenalty(): float {
        return $this->penalty;
    }
    public function setPenalty(float $penalty): void {
        $this->penalty = $penalty;
    }
    
}
