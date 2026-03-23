<?php 
  $titre_page = "Gestion Entreprise | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="entreprises.php" style="color: var(--accent-blue);">Entreprises</a> &gt;
    <span style="color: var(--text-muted);">Création / Modification</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Gérer une entreprise</h1>
  <p style="color: var(--text-muted);">Remplissez les informations ci-dessous pour mettre à jour le catalogue.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-entreprise.php" method="post" style="max-width: 800px;">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        
        <div class="form-group" style="grid-column: span 2;">
          <label for="nom">Nom de l'entreprise</label>
          <input type="text" id="nom" name="nom" placeholder="Ex: TechCorp SAS" required>
        </div>

        <div class="form-group">
          <label for="email">Email de contact professionnel</label>
          <input type="email" id="email" name="email" placeholder="contact@entreprise.com" required>
        </div>

        <div class="form-group">
          <label for="telephone">Téléphone</label>
          <input type="tel" id="telephone" name="telephone" placeholder="01 02 03 04 05">
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="ville">Ville du siège social</label>
          <input type="text" id="ville" name="ville" placeholder="Ex: Lyon, Paris, Nantes...">
        </div>

    </div>

    <div class="form-group" style="margin-top: 1.5rem;">
      <label for="description">Description de l'activité</label>
      <textarea id="description" name="description" rows="6" placeholder="Présentez brièvement l'entreprise et son secteur..."></textarea>
    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit">Enregistrer la fiche</button>
      <a href="entreprises.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
        Annuler et revenir
      </a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>