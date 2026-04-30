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

    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $brand = null;
    private ?string $model = null;
    private ?string $reservationStatus = null;

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

    public function getFirstName(): string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getBrand(): string {
        return $this->brand;
    }
    public function setBrand(string $brand): void {
        $this->brand = $brand;
    }

    public function getModel(): string {
        return $this->model;
    }
    public function setModel(string $model): void {
        $this->model = $model;
    }

    public function getReservationStatus(): string {
        return [
            'pending'   => 'Pendiente',
            'cancelled' => 'Cancelada',
            'finished'  => 'Finalizada',
            'renting'  => 'Alquilada',
            'supervising'  => 'Supervisando',
        ][$this->reservationStatus] ?? $this->reservationStatus;
    }
    public function setReservationStatus(string $reservationStatus): void {
        $this->reservationStatus = $reservationStatus;
    }

    public function getStatusClass(): string {
        return [
            'pending'   => 'status-pending',
            'cancelled' => 'status-cancelled',
            'finished'  => 'status-finished',
            'renting'  => 'status-renting',
            'supervising'  => 'status-supervising',
        ][$this->reservationStatus] ?? 'status-default';
    }
}
