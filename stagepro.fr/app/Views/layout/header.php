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

  <?php if (!isset($_COOKIE['cookie_consent'])): ?>
<div id="cookie-banner" style="
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #f5f5f5;
    padding: 1.5rem;
    border-top: 2px solid #ccc;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 9999;
">
    <div style="max-width: 1200px; margin: auto;">
        <p style="font-size: 0.9rem; margin-bottom: 1rem; color: #333;">
            Ce site utilise des cookies permettant de visualiser des contenus et d'améliorer le fonctionnement grâce aux statistiques de navigation.
            Vous pouvez accepter, refuser ou personnaliser vos choix.
        </p>

        <div style="display: flex; gap: 10px;">
            <a href="index.php?page=cookie-accept" style="
                background: #1e2bb8;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                font-weight: bold;
            ">Accepter</a>

            <a href="index.php?page=cookie-refuse" style="
                background: #1e2bb8;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                font-weight: bold;
            ">Refuser</a>

            <button onclick="toggleCookiesSettings()" style="
                border: 2px solid #1e2bb8;
                background: white;
                color: #1e2bb8;
                padding: 10px 20px;
                cursor: pointer;
            ">
                Personnaliser
            </button>
        </div>

        <!-- Zone personnalisation -->
        <div id="cookie-settings" style="display:none; margin-top:1rem;">
            <form method="get" action="index.php">
                <input type="hidden" name="page" value="cookie-accept">

                <label>
                    <input type="checkbox" checked disabled>
                    Cookies essentiels (obligatoires)
                </label><br>

                <label>
                    <input type="checkbox" name="stats">
                    Cookies statistiques
                </label><br><br>

                <button type="submit" style="
                    background:#1e2bb8;
                    color:white;
                    padding:8px 15px;
                    border:none;
                    cursor:pointer;
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