<?php
// app/Models/Wishlist.php

class Wishlist {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Ajoute une offre aux favoris
     */
    public function add($id_user, $id_offre) {
        // On utilise bien utilisateur_id et offre_id ici
        $sql = "INSERT IGNORE INTO wishlist (utilisateur_id, offre_id) VALUES (:u, :o)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['u' => $id_user, 'o' => $id_offre]);
    }

    /**
     * Retire une offre des favoris
     */
    public function remove($id_user, $id_offre) {
        // C'est ici que l'erreur Unknown column 'id_utilisateur' se produisait
        $sql = "DELETE FROM wishlist WHERE utilisateur_id = :u AND offre_id = :o";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['u' => $id_user, 'o' => $id_offre]);
    }

    /**
     * Récupère toutes les offres de la wishlist d'un utilisateur
     */
public function getUserWishlist($id_user) {
    // On remplace 'o.id_entreprise' par 'o.entreprise_id' (plus probable dans ta base)
    $sql = "SELECT o.*, e.nom as entreprise_nom 
            FROM wishlist w 
            JOIN offres o ON w.offre_id = o.id 
            JOIN entreprises e ON o.entreprise_id = e.id 
            WHERE w.utilisateur_id = :u";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['u' => $id_user]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}