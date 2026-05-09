<?php

namespace App\Models;

class Maintenance {

    private int $idMaintenance;
    private int $idBike;
    private int $idUser;
    private string $startDate;
    private ?string $endDate;
    private ?string $description;
    private ?float $cost;
    private ?string $bikeName = null;
    private ?string $userName = null;

    private static float $hourlyRate = 20.0;

    public function __construct(
        int $idMaintenance,
        int $idBike,
        int $idUser,
        string $startDate,
        ?string $bikeName = null,
        ?string $userName = null
    ) {
        $this->idMaintenance = $idMaintenance;
        $this->idBike = $idBike;
        $this->idUser = $idUser;
        $this->startDate = $startDate;
        $this->bikeName = $bikeName;
        $this->userName = $userName;
    }
    
    public function getIdMaintenance(): int {
        return $this->idMaintenance;
    }
    public function setIdMaintenance(int $idMaintenance): void {
        $this->idMaintenance = $idMaintenance;
    }

    public function getIdBike(): int {
        return $this->idBike;
    }
    public function setIdBike(int $idBike): void {
        $this->idBike = $idBike;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }
    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }

    public function getStartDate(): string {
        return $this->startDate;
    }
    public function setStartDate(string $startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?string {
        return $this->endDate;
    }
    public function setEndDate(?string $endDate): void {
        $this->endDate = $endDate;
    }

    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getCost(): ?float {
        return $this->cost;
    }
    public function setCost(?float $cost): void {
        $this->cost = $cost;
    }

    public function getBikeName(): string {
        return $this->bikeName;
    }
    public function setBikeName(string $bikeName): void {
        $this->bikeName = $bikeName;
    }

    public function getUserName(): string {
        return $this->userName;
    }
    public function setUserName(string $userName): void {
        $this->userName = $userName;
    }

    public static function getHourlyRate(): float {
        return self::$hourlyRate;
    }
    public static function setHourlyRate(float $rate): void {
        self::$hourlyRate = $rate;
    }

    public function getMinutesDifference(): int {
        if ($this->endDate === null) {
            return 0;
        }

        $start = new \DateTime($this->startDate);
        $end = new \DateTime($this->endDate);

        $diff = $start->diff($end);

        return ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
    }

    public function calculateWorkCost(int $minutes): float {
        $hours = ceil(($minutes / 60) * 10) / 10;
        return $hours * self::$hourlyRate;
    }
}