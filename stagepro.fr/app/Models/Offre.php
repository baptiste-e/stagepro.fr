<?php
require_once __DIR__ . '/../../config/Database.php';

class Offre {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function findAll(): array {
        $sql = "SELECT o.*, e.nom AS entreprise_nom
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                ORDER BY o.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search(array $filters = []): array {
        $sql = "SELECT o.*, e.nom AS entreprise_nom
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['titre'])) {
            $sql .= " AND o.titre LIKE :titre";
            $params[':titre'] = '%' . $filters['titre'] . '%';
        }

        if (!empty($filters['entreprise'])) {
            $sql .= " AND e.nom LIKE :entreprise";
            $params[':entreprise'] = '%' . $filters['entreprise'] . '%';
        }

        if (!empty($filters['competences'])) {
            $sql .= " AND o.competences LIKE :competences";
            $params[':competences'] = '%' . $filters['competences'] . '%';
        }

        if (isset($filters['remuneration']) && $filters['remuneration'] !== '') {
            $sql .= " AND o.remuneration >= :remuneration";
            $params[':remuneration'] = (float) $filters['remuneration'];
        }

        $sql .= " ORDER BY o.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false {
        $sql = "SELECT o.*, e.nom AS entreprise_nom
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                WHERE o.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO offres (
                    titre,
                    description,
                    competences,
                    localite,
                    duree,
                    remuneration,
                    nb_places,
                    entreprise_id
                ) VALUES (
                    :titre,
                    :description,
                    :competences,
                    :localite,
                    :duree,
                    :remuneration,
                    :nb_places,
                    :id_entreprise
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $data['titre'],
            ':description' => $data['description'],
            ':competences' => $data['competences'],
            ':localite' => $data['localite'],
            ':duree' => $data['duree'],
            ':remuneration' => $data['remuneration'] !== '' ? $data['remuneration'] : null,
            ':nb_places' => $data['nb_places'],
            ':id_entreprise' => $data['id_entreprise']
        ]);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE offres
                SET titre = :titre,
                    description = :description,
                    competences = :competences,
                    localite = :localite,
                    duree = :duree,
                    remuneration = :remuneration,
                    nb_places = :nb_places,
                    entreprise_id = :id_entreprise
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $data['titre'],
            ':description' => $data['description'],
            ':competences' => $data['competences'],
            ':localite' => $data['localite'],
            ':duree' => $data['duree'],
            ':remuneration' => $data['remuneration'] !== '' ? $data['remuneration'] : null,
            ':nb_places' => $data['nb_places'],
            ':id_entreprise' => $data['id_entreprise'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM offres WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function countAll(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
    }

    public function getStatsByLocalite(): array {
        $sql = "SELECT localite, COUNT(*) AS nb
                FROM offres
                GROUP BY localite
                ORDER BY nb DESC, localite ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatsByEntreprise(): array {
        $sql = "SELECT e.nom, COUNT(o.id) AS nb
                FROM entreprises e
                LEFT JOIN offres o ON e.id = o.entreprise_id
                GROUP BY e.id, e.nom
                ORDER BY nb DESC, e.nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}