<?php
require 'includes/auth.php';
require 'includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'pilote'])) {
    die('Accès refusé.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulaire-offre.php');
    exit;
}

$titre = trim($_POST['titre'] ?? '');
$entrepriseId = (int) ($_POST['entreprise_id'] ?? 0);
$date = trim($_POST['date'] ?? '');
$remuneration = trim($_POST['remuneration'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($titre === '' || $entrepriseId <= 0 || $date === '' || $description === '') {
    die('Veuillez remplir tous les champs obligatoires.');
}

// Vérifier que l'entreprise existe bien
$sqlEntreprise = "SELECT id FROM entreprises WHERE id = :id LIMIT 1";
$stmtEntreprise = $pdo->prepare($sqlEntreprise);
$stmtEntreprise->bindValue(':id', $entrepriseId, PDO::PARAM_INT);
$stmtEntreprise->execute();

$entreprise = $stmtEntreprise->fetch(PDO::FETCH_ASSOC);

if (!$entreprise) {
    die("Entreprise invalide.");
}

$sql = "INSERT INTO offres (entreprise_id, titre, description, remuneration, date_offre)
        VALUES (:entreprise_id, :titre, :description, :remuneration, :date_offre)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':entreprise_id', $entrepriseId, PDO::PARAM_INT);
$stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);

if ($remuneration === '') {
    $stmt->bindValue(':remuneration', null, PDO::PARAM_NULL);
} else {
    $stmt->bindValue(':remuneration', $remuneration);
}

$stmt->bindValue(':date_offre', $date, PDO::PARAM_STR);

$stmt->execute();

header('Location: offres.php');
exit;