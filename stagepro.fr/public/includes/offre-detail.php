<?php 
  $titre_page = "Détail de l'offre | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="offres.php" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);">Détail de l’offre</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
  
  <div>
    <section>
      <h1 style="font-size: 2.2rem; margin-bottom: 0.5rem;">Développeur Fullstack PHP / React</h1>
      <p style="font-size: 1.2rem; color: var(--accent-blue); margin-bottom: 2rem;">TechCorp SAS — Lyon (69)</p>
      
      <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Description du poste</h2>
        <p style="line-height: 1.8; color: var(--text-main);">
            Nous recherchons un stagiaire passionné pour intégrer notre équipe technique. Vous participerez au développement de nouvelles fonctionnalités sur notre plateforme SaaS, de la conception de l'API jusqu'à l'interface utilisateur.
        </p>
      </div>

      <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Compétences requises</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <span style="background: var(--surface-hover); border: 1px solid var(--accent-purple); color: var(--accent-purple); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">PHP 8+</span>
            <span style="background: var(--surface-hover); border: 1px solid var(--accent-purple); color: var(--accent-purple); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">React</span>
            <span style="background: var(--surface-hover); border: 1px solid var(--accent-purple); color: var(--accent-purple); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem;">MySQL</span>
        </div>
      </div>
    </section>

    <section id="postuler" style="margin-top: 4rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--accent-blue);">
      <h2 style="margin-bottom: 1.5rem;">Postuler à cette offre</h2>
      <form action="traitement-candidature.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_offre" value="123">
        
        <div class="form-group">
          <label for="cv">Votre CV (PDF)</label>
          <input type="file" id="cv" name="cv" accept=".pdf" required>
        </div>

        <div class="form-group">
          <label for="lm">Lettre de motivation</label>
          <textarea id="lm" name="lm" rows="6" placeholder="Exprimez votre intérêt pour ce poste..." required></textarea>
        </div>

        <button type="submit" style="width: 100%;">Envoyer ma candidature</button>
      </form>
    </section>
  </div>

  <aside>
    <div style="background: var(--surface); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 2rem;">
      <h3 style="font-size: 0.9rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 1.5rem;">Détails financiers</h3>
      <p style="font-size: 1.8rem; font-weight: bold; color: var(--accent-blue);">650 € <span style="font-size: 0.9rem; color: var(--text-muted);">/ mois</span></p>
      <p style="margin-top: 1rem; font-size: 0.9rem;"><strong>Date de début :</strong> 01/06/2026</p>
      <p style="font-size: 0.9rem;"><strong>Candidatures :</strong> 14 reçues</p>
      
      <button type="button" style="width: 100%; margin-top: 1.5rem; background: transparent; border: 1px solid var(--accent-purple); color: var(--accent-purple);">
        ⭐ Ajouter à la wish-list
      </button>
    </div>

    <div style="border: 1px dashed var(--border); padding: 1.5rem; border-radius: 8px;">
        <h3 style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">ADMINISTRATION</h3>
        <a href="formulaire-offre.php?id=123" class="btn-cta" style="display: block; text-align: center; font-size: 0.85rem; margin-bottom: 0.5rem;">Modifier l'offre</a>
        <button type="button" style="width: 100%; background: #ff4444; color: white; font-size: 0.85rem;">Supprimer</button>
    </div>
  </aside>

</div>

<?php include 'includes/footer.php'; ?>