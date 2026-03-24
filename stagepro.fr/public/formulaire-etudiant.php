<?php
require 'includes/auth.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'pilote'])) {
    die('Accès refusé.');
}

$titre_page = "Créer un étudiant | StagePro";
include 'includes/header.php';
?>

<section>
  <h1>Créer un étudiant</h1>
  <p style="color: var(--text-muted);">Ajoutez un nouveau compte étudiant.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-etudiant.php" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div style="margin-top: 2rem;">
      <button type="submit">Enregistrer</button>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>