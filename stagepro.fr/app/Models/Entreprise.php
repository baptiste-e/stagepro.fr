<?php
require_once __DIR__ . '/../../config/Database.php';

class Entreprise
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM entreprises ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $sql = "SELECT * FROM entreprises WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
    }

    public function countOffresLiees(int $id): int
    {
        $sql = "SELECT COUNT(*) FROM offres WHERE entreprise_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

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

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM entreprises WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}