<?php

namespace App\Models;

class Reservation
{
    private int $idReservation;
    private int $idUser;
    private int $idBike;
    private string $startDate;
    private string $endDate;
    private float $price;
    private int $idReservationStatus;

    public function __construct(
        int $idReservation = 0,
        int $idUser = 0,
        int $idBike = 0,
        string $startDate = '',
        string $endDate = '',
        float $price = 0.0,
        int $idReservationStatus = 0
    ) {
        $this->idReservation = $idReservation;
        $this->idUser = $idUser;
        $this->idBike = $idBike;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->price = $price;
        $this->idReservationStatus = $idReservationStatus;
    }

    public function getIdReservation(): int {
        return $this->idReservation;
    }
    public function setIdReservation(int $value): void {
        $this->idReservation = $value;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }
    public function setIdUser(int $value): void {
        $this->idUser = $value;
    }

    public function getIdBike(): int {
        return $this->idBike;
    }
    public function setIdBike(int $value): void {
        $this->idBike = $value;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }
    public function setStartDate(string $value): void {
        $this->startDate = $value;
    }

    public function getEndDate(): string {
        return $this->endDate;
    }
    public function setEndDate(string $value): void {
        $this->endDate = $value;
    }

    public function getPrice(): float {
        return $this->price;
    }
    public function setPrice(float $value): void {
        $this->price = $value;
    }

    public function getIdReservationStatus(): int {
        return $this->idReservationStatus;
    }
    public function setIdReservationStatus(int $value): void {
        $this->idReservationStatus = $value;
    }
}
