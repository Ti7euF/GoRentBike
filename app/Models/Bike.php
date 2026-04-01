<?php

namespace App\Models;

class Bike
{
    private int $idBike;
    private ?int $idStatusBike;
    private ?string $brand;
    private ?string $model;
    private ?string $type;
    private ?float $amortizationPrice;
    private ?float $dailyPrice;
    private ?float $totalKm;
    private bool $active;
    private ?string $frame;
    private ?string $gear;
    private ?string $brakes;
    private ?string $suspension;
    private ?string $tires;
    private ?string $seatpost;
    private ?string $path;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private int $rentalDays = 0;
    private int $discount = 0;
    private ?float $totalPrice = 0;

    private array $images = [];

    public function __construct(
        int $idBike = 0,
        ?int $idStatusBike = null,
        ?string $brand = null,
        ?string $model = null,
        ?string $type = null,
        bool $active = true
    ) {
        $this->idBike = $idBike;
        $this->idStatusBike = $idStatusBike;
        $this->brand = $brand;
        $this->model = $model;
        $this->type = $type;
        $this->active = $active;
    }

    public function getIdBike(): ?int { 
        return $this->idBike; 
    }
    public function setIdBike(?int $idBike): void { 
        $this->idBike = $idBike; 
    }

    public function getIdStatusBike(): ?int { 
        return $this->idStatusBike; 
    }
    public function setIdStatusBike(?int $idStatusBike): void { 
        $this->idStatusBike = $idStatusBike; 
    }

    public function getBrand(): ?string { 
        return $this->brand; 
    }
    public function setBrand(?string $brand): void { 
        $this->brand = $brand; 
    }

    public function getModel(): ?string { 
        return $this->model; }
    public function setModel(?string $model): void { 
        $this->model = $model; 
    }

    public function getType(): ?string { 
        return $this->type; 
    }
    public function setType(?string $type): void { 
        $this->type = $type; 
    }

    public function getAmortizationPrice(): ?float { 
        return $this->amortizationPrice; 
    }
    public function setAmortizationPrice(?float $amortizationPrice): void { 
        $this->amortizationPrice = $amortizationPrice; 
    }

    public function getDailyPrice(): ?float { 
        return $this->dailyPrice; 
    }
    public function setDailyPrice(?float $dailyPrice): void { 
        $this->dailyPrice = $dailyPrice; 
    }

    public function getTotalKm(): ?float { 
        return $this->totalKm; 
    }
    public function setTotalKm(?float $totalKm): void { 
        $this->totalKm = $totalKm; 
    }

    public function isActive(): bool { 
        return $this->active; 
    }
    public function setActive(bool $active): void { 
        $this->active = $active; 
    }

    public function getFrame(): ?string { 
        return $this->frame; 
    }
    public function setFrame(?string $frame): void { 
        $this->frame = $frame; 
    }

    public function getGear(): ?string { 
        return $this->gear; 
    }
    public function setGear(?string $gear): void { 
        $this->gear = $gear; 
    }

    public function getBrakes(): ?string { 
        return $this->brakes; 
    }
    public function setBrakes(?string $brakes): void { 
        $this->brakes = $brakes; 
    }

    public function getSuspension(): ?string { 
        return $this->suspension; 
    }
    public function setSuspension(?string $suspension): void { 
        $this->suspension = $suspension; 
    }

    public function getTires(): ?string { 
        return $this->tires; 
    }
    public function setTires(?string $tires): void { 
        $this->tires = $tires; 
    }

    public function getSeatpost(): ?string { 
        return $this->seatpost; 
    }
    public function setSeatpost(?string $seatpost): void { 
        $this->seatpost = $seatpost; 
    }

    public function getPath(): ?string { 
        return $this->path; 
    }
    public function setPath(?string $path): void { 
        $this->path = $path; 
    }

    public function getStartDate(): ?string { 
        return $this->startDate; 
    }
    public function setStartDate(?string $date) { 
        $this->startDate = $date; 
    }

    public function getEndDate(): ?string { 
        return $this->endDate; 
    }
    public function setEndDate(?string $date) { 
        $this->endDate = $date; 
    }

    public function getRentalDays(): int {
        return $this->rentalDays;
    }
    public function setRentalDays(int $rentalDays): void {
        $this->rentalDays = $rentalDays;
    }

    public function getDiscount(): int {
        return $this->discount;
    }
    public function setDiscount(int $discount): void {
        $this->discount = $discount;
    }

    public function getTotalPrice(): float {
        return $this->totalPrice;
    }
    public function setTotalPrice(float $totalPrice): void {
        $this->totalPrice = $totalPrice;
    }

    public function getImages(): array {
        return $this->images;
    }
    public function setImages(array $images): void {
        $this->images = $images;
    }

    public function addImage(array $image): void {
        $this->images[] = $image;
    }

    public function calculateRentalDays(): int {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        try {
            $start = new \DateTime($this->startDate);
            $end = new \DateTime($this->endDate);
        } catch (\Exception $e) {
            return 0;
        }

        return $start->diff($end)->days + 1;
    }

    public function calculateDiscount(int $days): int {
        if ($days >= 6) {
            return 50;
        }

        if ($days >= 3) {
            return 30;
        }

        if ($days >= 1) {
            return 15;
        }

        return 0;
    }

    public function calculateTotalPrice(): float {
        $price = $this->rentalDays * $this->dailyPrice;
        return $price - ($price * $this->discount / 100);
    }
}
