<?php 
  $titre_page = "Gestion Offre | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="offres.php" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);">Création / Modification</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Publier ou modifier une offre</h1>
  <p style="color: var(--text-muted);">Décrivez le poste et les compétences attendues pour attirer les meilleurs candidats.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-offre.php" method="post" style="max-width: 900px; background: var(--surface); padding: 2.5rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        
        <div class="form-group" style="grid-column: span 2;">
          <label for="titre">Intitulé du poste</label>
          <input type="text" id="titre" name="titre" placeholder="Ex: Développeur Web Fullstack H/F" required>
        </div>

        <div class="form-group">
          <label for="entreprise">Entreprise</label>
          <input type="text" id="entreprise" name="entreprise" placeholder="Nom de l'entreprise" required>
        </div>

        <div class="form-group">
          <label for="date">Date de début du stage</label>
          <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
          <label for="remuneration">Gratification mensuelle (€)</label>
          <input type="number" id="remuneration" name="remuneration" min="0" step="0.01" placeholder="Ex: 600">
        </div>

        <div class="form-group">
          <label for="competences">Tags / Compétences clés</label>
          <input type="text" id="competences" name="competences" placeholder="React, PHP, Docker..." required>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="description">Description détaillée des missions</label>
          <textarea id="description" name="description" rows="8" placeholder="Décrivez les projets, l'environnement technique, l'équipe..." required></textarea>
        </div>

    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit">Enregistrer l'offre</button>
      <a href="offres.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>