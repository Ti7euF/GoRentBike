<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\User;

class AuthRepository
{
    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    // Busca un usuario por email (para registro/login)
    public function findByEmail(string $email): ?User {
        $sql = "SELECT * FROM user WHERE email = ? AND active = 1 LIMIT 1";
        $result = $this->db->query($sql, [$email]);

        if (empty($result)) {
            return null;
        }

        $data = $result[0];

        return new User(
            (int)$data['idUser'],
            (int)$data['idRole'],
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['password'],
            (bool)$data['active']
        );
    }

    // Crea un usuario
    public function create(User $user): bool {
        $sql = "INSERT INTO user (idRole, firstName, lastName, email, password, active)
                VALUES (?, ?, ?, ?, ?, ?)";

        return $this->db->execute($sql, [
            $user->getIdRole(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->isActive() ? 1 : 0
        ]);
    }

    public function updatePassword($idUsuario, $hashedPassword) {
        $sql = "UPDATE user SET password = ? WHERE idUser = ?";
        return $this->db->execute($sql, [$hashedPassword, $idUsuario]);
    }
}
