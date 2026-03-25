<?php
require_once __DIR__ . '/../../config/Database.php';

class Entreprise
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
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
}