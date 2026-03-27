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
  <title><?= $titre_page ?? 'StagePro'; ?></title>
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
    <div id="cookie-banner" style="
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #f3f3f3;
      border-top: 1px solid #d0d0d0;
      padding: 20px 24px 16px 24px;
      z-index: 9999;
      box-sizing: border-box;
      box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.08);
    ">
      <div style="max-width: 1200px; margin: 0 auto;">
        <p style="
          margin: 0 0 16px 0;
          font-size: 0.95rem;
          line-height: 1.8;
          color: #1f2937;
        ">
          Ce site utilise des cookies permettant de visualiser des contenus et d’améliorer le fonctionnement grâce aux statistiques de navigation.
          Si vous cliquez sur « Accepter », StagePro et ses partenaires déposeront ces cookies sur votre terminal lors de votre navigation.
          Si vous cliquez sur « Refuser », ces cookies ne seront pas déposés.
          Votre choix est conservé pendant 6 mois et vous pouvez être informé et modifier vos préférences à tout moment.
        </p>

        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
          <a href="index.php?page=cookie-accept" style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: #ffffff !important;
            text-decoration: none !important;
            padding: 11px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid #2563eb;
            border-radius: 6px;
            min-width: 120px;
            box-sizing: border-box;
          ">
            Accepter
          </a>

          <a href="index.php?page=cookie-refuse" style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: #ffffff !important;
            text-decoration: none !important;
            padding: 11px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid #2563eb;
            border-radius: 6px;
            min-width: 120px;
            box-sizing: border-box;
          ">
            Refuser
          </a>

          <button type="button" onclick="toggleCookiesSettings()" style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #2563eb;
            padding: 11px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid #2563eb;
            border-radius: 6px;
            cursor: pointer;
            min-width: 140px;
            box-sizing: border-box;
          ">
            Personnaliser
          </button>
        </div>

        <div id="cookie-settings" style="
          display: none;
          margin-top: 16px;
          padding: 14px;
          background: #ffffff;
          border: 1px solid #d0d0d0;
          border-radius: 6px;
        ">
          <form method="get" action="index.php">
            <input type="hidden" name="page" value="cookie-accept">

            <div style="margin-bottom: 10px; font-size: 0.95rem; color: #1f2937;">
              <label>
                <input type="checkbox" checked disabled>
                Cookies essentiels (obligatoires)
              </label>
            </div>

            <div style="margin-bottom: 14px; font-size: 0.95rem; color: #1f2937;">
              <label>
                <input type="checkbox" name="stats">
                Cookies statistiques
              </label>
            </div>

            <button type="submit" style="
              background: #2563eb;
              color: #ffffff;
              padding: 10px 18px;
              border: 1px solid #2563eb;
              border-radius: 6px;
              cursor: pointer;
              font-size: 0.95rem;
              font-weight: 600;
            ">
              Enregistrer mes choix
            </button>
          </form>
        </div>
      </div>
    </div>

    <script>
      function toggleCookiesSettings() {
        const el = document.getElementById('cookie-settings');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
      }
    </script>
  <?php endif; ?>

  <main id="contenu">