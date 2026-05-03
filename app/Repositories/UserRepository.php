<?php

namespace App\Repositories;

use App\Services\Database;
use App\Models\User;

class UserRepository
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllUsers(int $offset, int $limit, string $sort, string $filter): array {
        $params = [];    
        
        $sql = "SELECT * FROM user WHERE 1 = 1";

        if ($filter !== "all") {
            $sql .= " AND (idUser LIKE :filter OR firstName LIKE :filter OR lastName LIKE :filter OR email LIKE :filter)";
            $params['filter'] = "%$filter%";
        }

        if ($sort === 'asc') {
            $sql .= " ORDER BY idUser ASC";
        } else {
            $sql .= " ORDER BY idUser DESC";
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $rows = $this->db->query($sql, $params);

        $users = [];
        foreach ($rows as $row) {
            $users[] = new User(
                $row['idUser'],
                $row['idRole'],
                $row['firstName'],
                $row['lastName'],
                $row['email'],
                $row['password'],
                (bool)$row['active']
            );
        }

        return $users;
    }

    public function countUsers(string $filter): int {
        $params = [];

        $sql = "SELECT COUNT(*) AS total 
                FROM user 
                WHERE 1 = 1";

        if ($filter !== "all") {
            $sql .= " AND lastName LIKE :filter";
            $params['filter'] = "%$filter%";
        }

        $result = $this->db->query($sql, $params);

        return (int) $result[0]['total'];
    }


    public function getUserById(int $idUser): ?User {
        $sql = "SELECT * FROM user WHERE idUser = :idUser LIMIT 1";
        $rows = $this->db->query($sql, ['idUser' => $idUser]);

        if (empty($rows)) {
            return null;
        }

        $row = $rows[0];

        return new User(
            $row['idUser'],
            $row['idRole'],
            $row['firstName'],
            $row['lastName'],
            $row['email'],
            $row['password']
        );
    }

    public function updateUser(int $idUser, string $firstName, string $lastName, string $email, ?int $role, ?string $password): bool {
        $sql = "UPDATE user SET firstName = :firstName, lastName = :lastName, email = :email";
        
        $params = [
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
            'idUser'    => $idUser
        ];

        if (!is_null($role)) {
            $sql .= ", idRole = :role";
            $params['role'] = $role;
        }

        if (!is_null($password)) {
            $sql .= ", password = :password";
            $params['password'] = $password;
        }

        $sql .= " WHERE idUser = :idUser";

        return $this->db->execute($sql, $params);
    }

    public function hasRegisters(int $idUser): bool{
        $sql = "SELECT COUNT(*) AS total
                FROM (SELECT idUser FROM maintenance WHERE idUser = :idUser
                      UNION ALL
                      SELECT idUser FROM reservation WHERE idUser = :idUser) AS t";

        $result = $this->db->query($sql, ['idUser' => $idUser]);

        return $result[0]['total'] > 0;
    }

    public function delete(int $idUser): bool {
        $sql = "DELETE FROM user WHERE idUser = :idUser";

        $params = ['idUser' => $idUser];

        return $this->db->execute($sql, $params);
    }
}
