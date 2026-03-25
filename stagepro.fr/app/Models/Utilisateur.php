<?php
// app/Models/Utilisateur.php
require_once __DIR__ . '/../../config/Database.php';

class Utilisateur {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère les utilisateurs par rôle
     */
    public function findByRole($roleNom) {
        $sql = "SELECT u.* FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id 
                WHERE r.nom = :role";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role' => $roleNom]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un utilisateur précis par son ID
     */
    public function findById($id) {
        $sql = "SELECT u.*, r.nom AS role_nom FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Compte le nombre d'utilisateurs par rôle
     */
    public function countByRole($roleNom) {
        $sql = "SELECT COUNT(*) FROM utilisateurs 
                JOIN roles ON utilisateurs.role_id = roles.id 
                WHERE roles.nom = :role";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role' => $roleNom]);
        return $stmt->fetchColumn();
    }

    /**
     * Trouve un utilisateur par email avec son rôle (pour le Login)
     */
    public function findByEmail($email) {
        $sql = "SELECT u.*, r.nom AS role_nom
                FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

} // <--- L'accolade de fin de classe doit être ICI, après la dernière méthode.