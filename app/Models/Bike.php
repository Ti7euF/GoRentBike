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

    private array $images = [];

    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // public function __construct(array $data)
    // {
    //     $this->idBike = $data['idBike'] ?? null;
    //     $this->idStatusBike = $data['idStatusBike'] ?? null;
    //     $this->brand = $data['brand'] ?? null;
    //     $this->model = $data['model'] ?? null;
    //     $this->type = $data['type'] ?? null;
    //     $this->amortizationPrice = isset($data['amortizationPrice']) ? (float)$data['amortizationPrice'] : null;
    //     $this->dailyPrice = isset($data['dailyPrice']) ? (float)$data['dailyPrice'] : null;
    //     $this->totalKm = isset($data['totalKm']) ? (float)$data['totalKm'] : null;
    //     $this->active = isset($data['active']) ? (bool)$data['active'] : true;
    //     $this->frame = $data['frame'] ?? null;
    //     $this->gear = $data['gear'] ?? null;
    //     $this->brakes = $data['brakes'] ?? null;
    //     $this->suspension = $data['suspension'] ?? null;
    //     $this->tires = $data['tires'] ?? null;
    //     $this->seatpost = $data['seatpost'] ?? null;
    // }

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

    public function getImages(): array {
        return $this->images;
    }
    public function setImages(array $images): void {
        $this->images = $images;
    }

    public function addImage(array $image): void {
        $this->images[] = $image;
    }
}
