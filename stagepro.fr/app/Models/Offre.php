<?php
// app/Models/Offre.php

require_once __DIR__ . '/../../config/Database.php';

class Offre {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère toutes les offres
     */
    public function findAll() {
        $sql = "SELECT offres.*, entreprises.nom AS entreprise_nom 
                FROM offres 
                JOIN entreprises ON offres.entreprise_id = entreprises.id 
                ORDER BY offres.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une offre par son ID
     */
    public function findById($id) {
        $sql = "SELECT offres.*, entreprises.nom AS entreprise_nom 
                FROM offres 
                JOIN entreprises ON offres.entreprise_id = entreprises.id 
                WHERE offres.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * CRÉATION : Ajoute une nouvelle offre
     */
    public function create($data) {
        // Note : On utilise :id_entreprise car c'est la clé envoyée par ton Controller
        $sql = "INSERT INTO offres (titre, description, competences, localite, duree, remuneration, nb_places, entreprise_id) 
                VALUES (:titre, :description, :competences, :localite, :duree, :remuneration, :nb_places, :id_entreprise)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * MISE À JOUR : Modifie une offre existante
     */
    public function update($id, $data) {
        $sql = "UPDATE offres SET 
                titre = :titre, 
                description = :description, 
                competences = :competences, 
                localite = :localite, 
                duree = :duree, 
                remuneration = :remuneration, 
                nb_places = :nb_places, 
                entreprise_id = :id_entreprise 
                WHERE id = :id";
        
        // On fusionne l'ID avec les données pour la clause WHERE
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Compte le nombre total d'offres (pour le dashboard)
     */
    public function countAll() {
        return $this->db->query("SELECT COUNT(*) FROM offres")->fetchColumn();
    }

    public function delete($id) {
        $sql = "DELETE FROM offres WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getStatsByLocalite() {
    $sql = "SELECT localite, COUNT(*) as nb FROM offres GROUP BY localite ORDER BY nb DESC";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public function getStatsByEntreprise() {
    $sql = "SELECT e.nom, COUNT(o.id) as nb 
            FROM entreprises e 
            LEFT JOIN offres o ON e.id = o.entreprise_id 
            GROUP BY e.id 
            ORDER BY nb DESC";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
}