<?php
require 'includes/db.php';
session_start();

// sécurité : vérifier connexion
if (!isset($_SESSION['user'])) {
    die("Vous devez être connecté");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_offre = (int) $_POST['id_offre'];
    $lettre = $_POST['lm'] ?? '';

    $utilisateur_id = $_SESSION['user']['id'];

    // gestion fichier CV
    $cv_name = $_FILES['cv']['name'] ?? '';
    $cv_tmp = $_FILES['cv']['tmp_name'] ?? '';

    if ($cv_tmp) {
        $chemin = 'uploads/' . time() . '_' . $cv_name;
        move_uploaded_file($cv_tmp, $chemin);
    } else {
        $chemin = null;
    }

    // insertion en BDD
    $sql = "INSERT INTO candidatures (utilisateur_id, offre_id, cv, lettre_motivation)
            VALUES (:user, :offre, :cv, :lettre)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user' => $utilisateur_id,
        'offre' => $id_offre,
        'cv' => $chemin,
        'lettre' => $lettre
    ]);

    header("Location: detail-offre.php?id=" . $id_offre);
    exit;
}