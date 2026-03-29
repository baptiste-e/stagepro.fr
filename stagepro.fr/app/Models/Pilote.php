<?php
// app/Models/Pilote.php
require_once __DIR__ . '/../../config/Database.php';

class Pilote {
    private $db;

    /**
     * Initialise la connexion à la base de données
     */
    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère tous les utilisateurs ayant le rôle 'pilote'
     * Utilise une jointure pour récupérer le nom du rôle en même temps
     */
    public function findAll() {
        $sql = "SELECT u.*, r.nom as role_nom 
                FROM utilisateurs u 
                JOIN roles r ON u.role_id = r.id 
                WHERE r.nom = 'pilote'
                ORDER BY u.nom ASC"; 
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un pilote spécifique par son ID
     * Vérifie également que l'utilisateur est bien un pilote pour plus de sécurité
     */
    public function findById($id) {
        $sql = "SELECT u.*, r.nom as role_nom 
                FROM utilisateurs u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :id AND r.nom = 'pilote'
                LIMIT 1";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => (int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}