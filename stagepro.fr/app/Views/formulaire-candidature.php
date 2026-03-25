<?php 
  $titre_page = "Postuler à une offre | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="offres.php" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);">Postuler</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 1rem;">Postuler à une offre</h1>
  <p style="color: var(--text-muted); margin-bottom: 2rem;">
    Envoyer une candidature avec un CV et une lettre de motivation.
  </p>
</section>

<section>
  <form action="traitement_candidature.php" method="post" enctype="multipart/form-data" aria-label="Formulaire de candidature">
    
    <div class="form-group">
      <label for="offre">Offre (référence / titre)</label>
      <input type="text" id="offre" name="offre" placeholder="Ex: Dev Web #1234" required>
    </div>

    <div class="form-group">
      <label for="cv">CV (Format PDF, DOCX)</label>
      <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
    </div>

    <div class="form-group">
      <label for="lm">Lettre de motivation</label>
      <textarea id="lm" name="lm" rows="8" placeholder="Expliquez vos motivations..." required></textarea>
    </div>

    <div style="margin-top: 2rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit">Envoyer la candidature</button>
      <a href="offres.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>