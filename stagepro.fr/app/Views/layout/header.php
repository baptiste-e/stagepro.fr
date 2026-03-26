<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cookieConsent = $_COOKIE['cookie_consent'] ?? null;
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
    <h1><a href="index.php?page=home">StagePro</a></h1>
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

  <?php if ($cookieConsent === null): ?>
    <div style="position: fixed; bottom: 20px; left: 20px; right: 20px; z-index: 9999; background: #111; color: #fff; padding: 1rem 1.25rem; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.25);">
      <p style="margin: 0 0 0.75rem 0;">
        Ce site utilise des cookies pour son bon fonctionnement et pour améliorer votre expérience.
      </p>

      <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="index.php?page=cookie-accept" class="btn-cta" style="text-decoration: none;">Accepter</a>
        <a href="index.php?page=cookie-refuse" style="padding: 0.6rem 1rem; border: 1px solid #888; color: white; text-decoration: none; border-radius: 6px;">
          Refuser
        </a>
      </div>
    </div>
  <?php endif; ?>

  <main id="contenu">