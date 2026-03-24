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
$entrepriseNom = trim($_POST['entreprise'] ?? '');
$date = trim($_POST['date'] ?? '');
$remuneration = trim($_POST['remuneration'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($titre === '' || $entrepriseNom === '' || $date === '' || $description === '') {
    die('Veuillez remplir tous les champs obligatoires.');
}

// Recherche de l'entreprise par son nom
$sqlEntreprise = "SELECT id FROM entreprises WHERE nom = :nom LIMIT 1";
$stmtEntreprise = $pdo->prepare($sqlEntreprise);
$stmtEntreprise->bindValue(':nom', $entrepriseNom, PDO::PARAM_STR);
$stmtEntreprise->execute();

$entreprise = $stmtEntreprise->fetch(PDO::FETCH_ASSOC);

if (!$entreprise) {
    die("Entreprise introuvable. Créez d'abord l'entreprise avant de publier une offre.");
}

$entrepriseId = (int) $entreprise['id'];

$sql = "INSERT INTO offres (entreprise_id, titre, description, remuneration, date_offre)
        VALUES (:entreprise_id, :titre, :description, :remuneration, :date_offre)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':entreprise_id', $entrepriseId, PDO::PARAM_INT);
$stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':remuneration', $remuneration !== '' ? $remuneration : null);
$stmt->bindValue(':date_offre', $date, PDO::PARAM_STR);

$stmt->execute();

header('Location: offres.php');
exit;