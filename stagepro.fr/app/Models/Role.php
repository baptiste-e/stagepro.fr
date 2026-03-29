<?php
// app/Models/Role.php
require_once __DIR__ . '/../../config/Database.php';

class Role {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère tous les rôles (utile pour des listes déroulantes de création d'utilisateur)
     */
    public function findAll(): array {
        $sql = "SELECT * FROM roles ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un rôle spécifique par son ID
     */
    public function findById(int $id): array|false {
        $sql = "SELECT * FROM roles WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un rôle par son nom (ex: 'etudiant', 'pilote', 'admin')
     * Très utile pour les contrôleurs afin de récupérer l'ID dynamiquement sans le "hardcoder"
     */
    public function findByNom(string $nom): array|false {
        $sql = "SELECT * FROM roles WHERE nom = :nom LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nom' => $nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}