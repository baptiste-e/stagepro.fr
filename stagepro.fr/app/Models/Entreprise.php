<?php
// app/Models/Entreprise.php
require_once __DIR__ . '/../../config/Database.php';

class Entreprise {
    private $db;

    public function __construct() {
        // On récupère la connexion via ta classe Database
        $this->db = Database::getConnection();
    }

    /**
     * Récupère toutes les entreprises
     */
    public function findAll() {
        return $this->db->query("SELECT * FROM entreprises")->fetchAll();
    }

    /**
     * Récupère une entreprise par son ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM entreprises WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Compte le nombre total d'entreprises (pour le dashboard admin)
     */
    public function countAll() {
        return $this->db->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
    }
} // <--- C'est CETTE accolade qui doit être la TOUTE DERNIÈRE du fichier