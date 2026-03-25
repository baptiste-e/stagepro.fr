<?php
require_once __DIR__ . '/../../config/Database.php';

class Offre {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findAll() {
        $sql = "SELECT offres.*, entreprises.nom AS entreprise_nom 
                FROM offres 
                JOIN entreprises ON offres.entreprise_id = entreprises.id 
                ORDER BY offres.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($filters = []) {
        $sql = "SELECT offres.*, entreprises.nom AS entreprise_nom
                FROM offres
                JOIN entreprises ON offres.entreprise_id = entreprises.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['titre'])) {
            $sql .= " AND offres.titre LIKE :titre";
            $params['titre'] = '%' . $filters['titre'] . '%';
        }

        if (!empty($filters['entreprise'])) {
            $sql .= " AND entreprises.nom LIKE :entreprise";
            $params['entreprise'] = '%' . $filters['entreprise'] . '%';
        }

        if (!empty($filters['competences'])) {
            $sql .= " AND offres.competences LIKE :competences";
            $params['competences'] = '%' . $filters['competences'] . '%';
        }

        if ($filters['remuneration'] !== '' && $filters['remuneration'] !== null) {
            $sql .= " AND offres.remuneration >= :remuneration";
            $params['remuneration'] = (float)$filters['remuneration'];
        }

        $sql .= " ORDER BY offres.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT offres.*, entreprises.nom AS entreprise_nom 
                FROM offres 
                JOIN entreprises ON offres.entreprise_id = entreprises.id 
                WHERE offres.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO offres (titre, description, competences, localite, duree, remuneration, nb_places, entreprise_id) 
                VALUES (:titre, :description, :competences, :localite, :duree, :remuneration, :nb_places, :id_entreprise)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

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
        
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

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