<?php 
  $titre_page = "Toutes les Offres | StagePro";
  include 'includes/header.php'; 
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Catalogue des offres</h1>
      <p style="color: var(--text-muted);">Explorez les opportunités de stage et propulsez votre carrière.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="offres-statistiques.php" style="color: var(--accent-purple); text-decoration: none; font-size: 0.9rem; padding-top: 10px;">📊 Statistiques</a>
        <a href="formulaire-offre.php" class="btn-cta" style="font-size: 0.85rem;">+ Publier une offre</a>
    </div>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem; color: var(--accent-blue);">Filtrer les résultats</h2>
  
  <form action="offres.php" method="get">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem;">
      
      <div class="form-group">
        <label for="titre">Titre / Mot-clé</label>
        <input type="search" id="titre" name="titre" placeholder="Développeur...">
      </div>

      <div class="form-group">
        <label for="entreprise">Entreprise</label>
        <input type="text" id="entreprise" name="entreprise" placeholder="Ex: TechCorp">
      </div>

      <div class="form-group">
        <label for="competences">Compétences</label>
        <input type="text" id="competences" name="competences" placeholder="SQL, React...">
      </div>

      <div class="form-group">
        <label for="remuneration">Gratification min. (€)</label>
        <input type="number" id="remuneration" name="remuneration" min="0" placeholder="Ex: 600">
      </div>

      <div class="form-group">
        <label for="date">Date de l'offre</label>
        <input type="date" id="date" name="date">
      </div>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
      <button type="submit">Rechercher</button>
      <button type="reset" style="background: transparent; border: 1px solid var(--border); color: var(--text-muted);">Réinitialiser</button>
    </div>
  </form>
</section>

<section style="margin-top: 3rem;">
  <h2>Offres de stage disponibles</h2>
  
  <div class="container-espaces" style="margin-top: 1.5rem;">
      
      <article class="card">
        <h3 style="color: var(--accent-blue);">Développeur Fullstack PHP</h3>
        <p><strong>Entreprise :</strong> TechCorp</p>
        <p style="font-size: 0.85rem; margin: 0.5rem 0;">📍 Lyon (69)</p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">Compétences : PHP, React, MySQL</p>
        <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <span style="color: var(--accent-purple); font-weight: bold;">650 €/mois</span>
            <span style="font-size: 0.75rem;">Publié le 12/03</span>
        </div>
        <a href="detail-offre.php?id=101" class="lien-etendu"></a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">Data Analyst Stagiaire</h3>
        <p><strong>Entreprise :</strong> DataFlow</p>
        <p style="font-size: 0.85rem; margin: 0.5rem 0;">📍 Paris (75)</p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">Compétences : Python, Tableau, Excel</p>
        <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <span style="color: var(--accent-purple); font-weight: bold;">800 €/mois</span>
            <span style="font-size: 0.75rem;">Publié le 10/03</span>
        </div>
        <a href="detail-offre.php?id=102" class="lien-etendu"></a>
      </article>

  </div>

  <nav aria-label="Pagination" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt; Précédent</button>
    <button type="button" class="btn-cta" style="padding: 5px 15px;">1</button>
    <button type="button" style="padding: 5px 15px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 15px; background: var(--surface); border: 1px solid var(--border);">Suivant &gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>