<?php
// app/Models/Utilisateur.php
require_once __DIR__ . '/../../config/Database.php';

class Utilisateur {
    private $db;

    /**
     * Initialise la connexion à la base de données
     */
    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère les utilisateurs selon leur nom de rôle (ex: 'etudiant', 'pilote')
     */
    public function findByRole($roleNom) {
        $sql = "SELECT u.*, r.nom AS role_nom
                FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE r.nom = :role
                ORDER BY u.nom, u.prenom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role' => $roleNom]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre d'utilisateurs pour un rôle donné (utile pour le Dashboard Admin)
     */
    public function countByRole($roleNom) {
        $sql = "SELECT COUNT(*) 
                FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE r.nom = :role";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['role' => $roleNom]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Récupère un utilisateur par son ID avec le nom de son rôle
     */
    public function findById($id) {
        $sql = "SELECT u.*, r.nom AS role_nom
                FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son email (utilisé pour la connexion)
     */
    public function findByEmail($email) {
        $sql = "SELECT u.*, r.nom AS role_nom
                FROM utilisateurs u
                JOIN roles r ON u.role_id = r.id
                WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel utilisateur (Étudiant, Pilote ou Admin)
     */
    public function create($data) {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id) 
                VALUES (:nom, :prenom, :email, :mdp, :role_id)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom'     => $data['nom'],
            'prenom'  => $data['prenom'],
            'email'   => $data['email'],
            'mdp'     => $data['mot_de_passe'], // Doit être déjà haché par le contrôleur
            'role_id' => $data['role_id']
        ]);
    }

    /**
     * Met à jour un utilisateur avec gestion optionnelle du mot de passe
     */
    public function update($id, $data) {
        $sql = "UPDATE utilisateurs 
                SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id";
        
        $params = [
            'nom'     => $data['nom'],
            'prenom'  => $data['prenom'],
            'email'   => $data['email'],
            'role_id' => $data['role_id'],
            'id'      => $id
        ];

        // On n'ajoute le mot de passe à la requête que s'il a été modifié
        if (!empty($data['mot_de_passe'])) {
            $sql .= ", mot_de_passe = :mdp";
            $params['mdp'] = $data['mot_de_passe'];
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Supprime un utilisateur
     */
    public function delete($id) {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}