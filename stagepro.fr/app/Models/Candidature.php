<?php
// app/Models/Candidature.php
require_once __DIR__ . '/../../config/Database.php';

class Candidature {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère une candidature avec tous les détails de l'offre et de l'entreprise associée
     */
    public function findByIdFull($id) {
        $sql = "SELECT c.*, o.titre AS offre_titre, o.description AS offre_desc,
                       o.localite, o.remuneration, e.nom AS entreprise_nom
                FROM candidatures c
                JOIN offres o ON c.offre_id = o.id
                JOIN entreprises e ON o.entreprise_id = e.id
                WHERE c.id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les candidatures d'un étudiant spécifique (pour son interface "Mes Candidatures")
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère TOUTES les candidatures avec les infos étudiants (pour Admin / Pilote)
     */
    public function findAllFull() {
        $sql = "SELECT c.*, 
                       o.titre AS offre_titre,
                       e.nom AS entreprise_nom,
                       u.nom AS etudiant_nom,
                       u.prenom AS etudiant_prenom,
                       u.email AS etudiant_email
                FROM candidatures c
                JOIN offres o ON c.offre_id = o.id
                JOIN entreprises e ON o.entreprise_id = e.id
                JOIN utilisateurs u ON c.utilisateur_id = u.id
                ORDER BY c.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un étudiant a déjà postulé à une offre précise (évite les doublons)
     */
    public function findSpecific($userId, $offreId) {
        $sql = "SELECT *
                FROM candidatures
                WHERE utilisateur_id = :user_id
                  AND offre_id = :offre_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id'  => (int)$userId,
            'offre_id' => (int)$offreId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle candidature avec un statut initial "en_attente"
     */
    public function create($userId, $offreId, $cvPath, $lettre) {
        $sql = "INSERT INTO candidatures (utilisateur_id, offre_id, cv, lettre_motivation, statut)
                VALUES (:user, :offre, :cv, :lettre, :statut)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user'   => $userId,
            'offre'  => $offreId,
            'cv'     => $cvPath,
            'lettre' => $lettre,
            'statut' => 'en_attente'
        ]);
    }

    /**
     * Met à jour le statut d'une candidature (Acceptée, Refusée, etc.)
     */
    public function updateStatut($id, $statut) {
        $statutsAutorises = ['en_attente', 'acceptee', 'refusee'];

        if (!in_array($statut, $statutsAutorises, true)) {
            return false;
        }

        $sql = "UPDATE candidatures
                SET statut = :statut
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => (int)$id,
            'statut' => $statut
        ]);
    }

    /**
     * Supprime une candidature (sécurisé par le double ID pour éviter les erreurs de suppression)
     */
    public function deleteByIdentifiers($id_candidature, $userId) {
        $sql = "DELETE FROM candidatures
                WHERE id = :id
                  AND utilisateur_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => (int)$id_candidature,
            'user_id' => (int)$userId
        ]);
    }
}