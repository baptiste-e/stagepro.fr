<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titre_page ?? 'StagePro'; ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>StagePro</h1>
    <nav aria-label="Navigation principale">
      <ul>
          <li><a href="index.php?page=home">Accueil</a></li>
          <li><a href="index.php?page=offres">Offres</a></li>
          <li><a href="index.php?page=candidatures">Candidatures</a></li>
          <li><a href="index.php?page=entreprises">Entreprises</a></li>

          <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'], true)): ?>
              <li><a href="index.php?page=etudiants">Étudiants</a></li>
          <?php endif; ?>

          <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'], true)): ?>
              <li><a href="index.php?page=pilotes">Pilotes</a></li>
          <?php endif; ?>

          <li><a href="index.php?page=wishlist">Wish-List</a></li>

          <?php if (isset($_SESSION['user'])): ?>
              <li>
                  <strong><?= htmlspecialchars($_SESSION['user']['prenom']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)</strong>
              </li>
              <li><a href="index.php?page=logout">Déconnexion</a></li>
          <?php else: ?>
              <li><a href="index.php?page=login">Connexion</a></li>
          <?php endif; ?>
      </ul>
    </nav>
  </header>
  <main id="contenu">