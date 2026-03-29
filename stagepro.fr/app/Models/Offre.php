<?php
// app/Models/Offre.php
require_once __DIR__ . '/../../config/Database.php';

class Offre {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère toutes les offres avec le nom de l'entreprise, triées par date
     */
    public function findAll(): array {
        $sql = "SELECT o.*, e.nom AS entreprise_nom
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                ORDER BY o.date_offre DESC, o.id DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche multicritère incluant les filtres de dates
     */
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
            $params[':remuneration'] = (float)$filters['remuneration'];
        }

        // Filtres de dates (Logique fusionnée)
        if (!empty($filters['date_offre'])) {
            $sql .= " AND o.date_offre = :date_offre";
            $params[':date_offre'] = $filters['date_offre'];
        }

        if (!empty($filters['date_debut'])) {
            $sql .= " AND o.date_offre >= :date_debut";
            $params[':date_debut'] = $filters['date_debut'];
        }

        if (!empty($filters['date_fin'])) {
            $sql .= " AND o.date_offre <= :date_fin";
            $params[':date_fin'] = $filters['date_fin'];
        }

        $sql .= " ORDER BY o.date_offre DESC, o.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une offre par son ID
     */
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

    /**
     * Crée une offre avec gestion de la date de publication
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO offres (
                    titre, description, competences, localite, 
                    duree, remuneration, nb_places, entreprise_id, date_offre
                ) VALUES (
                    :titre, :description, :competences, :localite, 
                    :duree, :remuneration, :nb_places, :id_entreprise, :date_offre
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre'         => $data['titre'],
            ':description'   => $data['description'],
            ':competences'   => $data['competences'],
            ':localite'      => $data['localite'] !== '' ? $data['localite'] : null,
            ':duree'         => $data['duree'] !== '' ? $data['duree'] : null,
            ':remuneration'  => $data['remuneration'] !== '' ? $data['remuneration'] : null,
            ':nb_places'     => $data['nb_places'],
            ':id_entreprise' => $data['id_entreprise'],
            ':date_offre'    => $data['date_offre'] ?? date('Y-m-d')
        ]);
    }

    /**
     * Met à jour une offre existante
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE offres
                SET titre = :titre,
                    description = :description,
                    competences = :competences,
                    localite = :localite,
                    duree = :duree,
                    remuneration = :remuneration,
                    nb_places = :nb_places,
                    entreprise_id = :id_entreprise,
                    date_offre = :date_offre
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre'         => $data['titre'],
            ':description'   => $data['description'],
            ':competences'   => $data['competences'],
            ':localite'      => $data['localite'] !== '' ? $data['localite'] : null,
            ':duree'         => $data['duree'] !== '' ? $data['duree'] : null,
            ':remuneration'  => $data['remuneration'] !== '' ? $data['remuneration'] : null,
            ':nb_places'     => $data['nb_places'],
            ':id_entreprise' => $data['id_entreprise'],
            ':date_offre'    => $data['date_offre'],
            ':id'            => $id
        ]);
    }

    /**
     * Suppression sécurisée avec nettoyage des dépendances (Transaction)
     */
    public function delete(int $id): bool {
        try {
            $this->pdo->beginTransaction();

            // 1. Supprimer les candidatures liées
            $stmt1 = $this->pdo->prepare("DELETE FROM candidatures WHERE offre_id = :id");
            $stmt1->execute([':id' => $id]);

            // 2. Supprimer de la wishlist
            $stmt2 = $this->pdo->prepare("DELETE FROM wishlist WHERE offre_id = :id");
            $stmt2->execute([':id' => $id]);

            // 3. Supprimer l'offre
            $stmt3 = $this->pdo->prepare("DELETE FROM offres WHERE id = :id");
            $stmt3->execute([':id' => $id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function countAll(): int {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
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