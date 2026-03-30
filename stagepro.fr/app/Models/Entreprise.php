<?php
// app/Models/Entreprise.php
require_once __DIR__ . '/../../config/Database.php';

class Entreprise
{
    private PDO $pdo;

    /**
     * Initialise la connexion à la base de données
     */
    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère toutes les entreprises classées par nom
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM entreprises ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * RÉVISION SFx 5 : Récupère une entreprise par son ID avec sa note moyenne
     */
    public function findById(int $id): array|false
    {
        // On utilise un LEFT JOIN pour ne pas cacher l'entreprise si elle n'a pas encore d'avis
        $sql = "SELECT e.*, 
                       IFNULL(ROUND(AVG(ev.note), 1), 0.0) AS note_moyenne
                FROM entreprises e
                LEFT JOIN evaluations ev ON e.id = ev.entreprise_id
                WHERE e.id = :id
                GROUP BY e.id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre total d'entreprises (pour les stats globales)
     */
    public function countAll(): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
    }

    /**
     * Compte le nombre d'offres de stage postées par une entreprise précise
     */
    public function countOffresLiees(int $id): int
    {
        $sql = "SELECT COUNT(*) FROM offres WHERE entreprise_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * Ajoute une nouvelle entreprise en base
     */
    public function create(string $nom, string $description, string $email, string $telephone): bool
    {
        $sql = "INSERT INTO entreprises (nom, description, email_contact, telephone_contact)
                VALUES (:nom, :description, :email_contact, :telephone_contact)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':email_contact' => $email !== '' ? $email : null,
            ':telephone_contact' => $telephone !== '' ? $telephone : null
        ]);
    }

    /**
     * Met à jour les informations d'une entreprise
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE entreprises
                SET nom = :nom,
                    description = :description,
                    email_contact = :email_contact,
                    telephone_contact = :telephone_contact
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':description' => $data['description'],
            ':email_contact' => $data['email_contact'] !== '' ? $data['email_contact'] : null,
            ':telephone_contact' => $data['telephone_contact'] !== '' ? $data['telephone_contact'] : null,
            ':id' => $id
        ]);
    }

    /**
     * Supprime une entreprise par son ID
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM entreprises WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * SFx 5 : Enregistre une évaluation pour une entreprise
     */
    public function addEvaluation($entrepriseId, $userId, $note, $commentaire) 
    {
        $sql = "INSERT INTO evaluations (entreprise_id, utilisateur_id, note, commentaire) 
                VALUES (:eid, :uid, :note, :comm)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'eid'  => (int)$entrepriseId,
            'uid'  => (int)$userId,
            'note' => (int)$note,
            'comm' => htmlspecialchars($commentaire)
        ]);
    }

public function getEvaluations(int $id): array {
    $sql = "SELECT ev.*, u.nom, u.prenom
            FROM evaluations ev
            JOIN utilisateurs u ON ev.utilisateur_id = u.id
            WHERE ev.entreprise_id = :id
            ORDER BY ev.created_at DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
} // Fin de la classe