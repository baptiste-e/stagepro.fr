<?php
// app/Models/Wishlist.php
require_once __DIR__ . '/../../config/Database.php';

class Wishlist {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Ajoute une offre aux favoris
     */
    public function add($id_user, $id_offre) {
        $sql = "INSERT IGNORE INTO wishlist (utilisateur_id, offre_id) VALUES (:u, :o)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'u' => $id_user,
            'o' => $id_offre
        ]);
    }

    /**
     * Retire une offre des favoris
     */
    public function remove($id_user, $id_offre) {
        $sql = "DELETE FROM wishlist WHERE utilisateur_id = :u AND offre_id = :o";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'u' => $id_user,
            'o' => $id_offre
        ]);
    }

    /**
     * Récupère toutes les offres de la wishlist d'un utilisateur
     */
    public function getUserWishlist($id_user) {
        $sql = "SELECT 
                    o.*, 
                    e.nom AS entreprise_nom,
                    w.created_at AS wishlist_created_at
                FROM wishlist w
                JOIN offres o ON w.offre_id = o.id
                JOIN entreprises e ON o.entreprise_id = e.id
                WHERE w.utilisateur_id = :u
                ORDER BY w.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['u' => $id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}