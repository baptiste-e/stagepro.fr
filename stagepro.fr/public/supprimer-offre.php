<?php
require 'includes/auth.php';
require 'includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'pilote'])) {
    die('Accès refusé.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: offres.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    die('ID invalide.');
}

$sql = "DELETE FROM offres WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: offres.php');
exit;