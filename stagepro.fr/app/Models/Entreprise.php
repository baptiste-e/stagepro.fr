<?php
require_once __DIR__ . '/../../config/Database.php';

class Entreprise {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findAll() {
        return $this->db->query("SELECT * FROM entreprises")->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM entreprises WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function countAll() {
        return $this->db->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
    }

    public function countOffresLiees($id) {
        $sql = "SELECT COUNT(*) FROM offres WHERE entreprise_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return (int)$stmt->fetchColumn();
    }

    public function update($id, $data) {
        $sql = "UPDATE entreprises
                SET nom = :nom,
                    description = :description,
                    email_contact = :email_contact,
                    telephone_contact = :telephone_contact
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom' => $data['nom'],
            'description' => $data['description'],
            'email_contact' => $data['email_contact'],
            'telephone_contact' => $data['telephone_contact'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM entreprises WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}