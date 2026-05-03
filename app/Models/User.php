<?php

namespace App\Models;

class User
{
    private ?int $idUser;
    private int $idRole;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private bool $active;

    public function __construct(
        int $idUser = 0,
        int $idRole = 0,
        string $firstName = '',
        string $lastName = '',
        string $email = '',
        string $password = '',
        bool $active = true
    ) {
        $this->idUser = $idUser;
        $this->idRole = $idRole;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
    }

    //Getters
    public function getIdUser(): ?int {
        return $this->idUser;
    }

    public function getIdRole(): int {
        return $this->idRole;
    }
    public function setIdRole(int $idRole): void {
        $this->idRole = $idRole;
    }

    public function getfirstName(): string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getlastName(): string {
        return $this->lastName;
    }
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function isActive(): bool {
        return $this->active;
    }
    public function setActivo(bool $active): void {
        $this->active = $active;
    }


    public function getRoleName(): string {
        return match ($this->idRole) {
            1 => 'Administrador',
            2 => 'Técnico',
            3 => 'Facturación',
            4 => 'Cliente',
            default => 'Desconocido'
        };
    }
}