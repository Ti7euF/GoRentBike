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

    public function __construct(array $data)
    {
        $this->idUser = $data['idUser'] ?? null;
        $this->idRole = $data['idRole'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->active = (bool)$data['active'];
    }

    //Getters
    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getIdRole(): int
    {
        return $this->idRole;
    }

    public function getfirstName(): string
    {
        return $this->firstName;
    }

    public function getlastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    //Setters
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setActivo(bool $active): void
    {
        $this->active = $active;
    }
}