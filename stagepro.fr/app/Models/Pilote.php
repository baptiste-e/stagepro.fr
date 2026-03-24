<?php
// app/Models/Pilote.php
require_once __DIR__ . '/../../config/Database.php';

class Pilote {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère tous les pilotes uniquement
     */
    public function findAll() {
        $sql = "SELECT u.*, r.nom as role_nom 
                FROM utilisateurs u 
                JOIN roles r ON u.role_id = r.id 
                WHERE r.nom = 'pilote'"; // On filtre ici !
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un pilote spécifique par son ID
     */
    public function findById($id) {
        $sql = "SELECT u.*, r.nom as role_nom 
                FROM utilisateurs u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :id AND r.nom = 'pilote'";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}