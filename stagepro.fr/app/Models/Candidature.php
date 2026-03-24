<?php
// app/Models/Candidature.php
require_once __DIR__ . '/../../config/Database.php';

class Candidature {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère les candidatures d'un étudiant spécifique
     */
    public function findByEtudiant($userId) {
        $sql = "SELECT c.*, o.titre AS offre_titre, e.nom AS entreprise_nom
                FROM candidatures c
                JOIN offres o ON c.offre_id = o.id
                JOIN entreprises e ON o.entreprise_id = e.id
                WHERE c.utilisateur_id = :id
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Enregistre une nouvelle candidature
     */
    public function create($userId, $offreId, $cvPath, $lettre) {
        $sql = "INSERT INTO candidatures (utilisateur_id, offre_id, cv, lettre_motivation)
                VALUES (:user, :offre, :cv, :lettre)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user' => $userId,
            'offre' => $offreId,
            'cv' => $cvPath,
            'lettre' => $lettre
        ]);
    }
}