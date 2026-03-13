<?php 
  $titre_page = "Gestion des Candidatures | StagePro";
  include 'includes/header.php'; 
?>

<section>
  <h1>Gestion des candidatures</h1>
  <p style="color: var(--text-muted);">Consulter et filtrer les candidatures envoyées sur la plateforme.</p>
  
  <div style="margin-top: 1rem;">
      <a href="detail-candidature.php" class="btn-cta" style="font-size: 0.8rem; padding: 8px 15px;">
        🔍 Accéder au dernier détail
      </a>
  </div>
</section>

<section style="margin-top: 3rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; color: var(--accent-blue);">Rechercher une candidature</h2>

  <form action="gestion-candidatures.php" method="get" aria-label="Formulaire de recherche">
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        
        <div class="form-group">
          <label for="offre">Offre (titre)</label>
          <input type="text" id="offre" name="offre" placeholder="Ex: Développeur...">
        </div>

        <div class="form-group">
          <label for="entreprise">Entreprise</label>
          <input type="text" id="entreprise" name="entreprise" placeholder="Ex: TechCorp">
        </div>

        <div class="form-group">
          <label for="etudiant">Étudiant</label>
          <input type="text" id="etudiant" name="etudiant" placeholder="Nom ou prénom">
        </div>

        <div class="form-group">
          <label for="pilote">Pilote</label>
          <input type="text" id="pilote" name="pilote" placeholder="Nom du tuteur">
        </div>

        <div class="form-group">
          <label for="date">Date de candidature</label>
          <input type="date" id="date" name="date">
        </div>

    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
      <button type="submit">Rechercher</button>
      <button type="reset" style="background: transparent; border: 1px solid var(--border); color: var(--text-muted);">
        Réinitialiser
      </button>
    </div>
  </form>
</section>

<section style="margin-top: 3rem;">
  <h2>Résultats de la recherche</h2>
  
  <div class="container-espaces" style="margin-top: 1.5rem;">
      <article class="card">
          <h3 style="font-size: 0.9rem;">Candidature #124</h3>
          <p><strong>Étudiant :</strong> Jean Dupont</p>
          <p><strong>Offre :</strong> Dev Web @TechCorp</p>
          <p style="font-size: 0.8rem; color: var(--accent-purple);">Pilote : Mme Martin</p>
          <a href="detail-candidature.php?id=124" class="lien-etendu">Voir</a>
      </article>
      
      <?php if(false): ?>
        <p>Aucune candidature ne correspond à vos critères.</p>
      <?php endif; ?>
  </div>

  <nav aria-label="Pagination" style="margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>