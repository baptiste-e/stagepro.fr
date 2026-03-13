<?php 
  $titre_page = "Mes Candidatures | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Mes candidatures</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Mes candidatures</h1>
  <p style="color: var(--text-muted);">Retrouvez les offres auxquelles vous avez postulé (SFx21).</p>
</section>

<section>
  <h2 style="margin: 2rem 0 1rem;">Liste des candidatures</h2>
  
  <div class="container-espaces">
      <article class="card">
        <h3 style="color: var(--accent-blue);">Développeur Web</h3>
        <p><strong>Entreprise :</strong> TechCorp</p>
        <p><strong>Statut :</strong> <span style="color: #fbbf24;">En attente</span></p>
        <p style="font-size: 0.75rem;">Postulé le 10/03/2026</p>
        <a href="detail-candidature.php?id=1" class="lien-etendu">Voir le détail</a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">Data Analyst</h3>
        <p><strong>Entreprise :</strong> DataFlow</p>
        <p><strong>Statut :</strong> <span style="color: #4ade80;">Accepté</span></p>
        <p style="font-size: 0.75rem;">Postulé le 05/03/2026</p>
        <a href="detail-candidature.php?id=2" class="lien-etendu">Voir le détail</a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">UI/UX Designer</h3>
        <p><strong>Entreprise :</strong> CreativeLab</p>
        <p><strong>Statut :</strong> <span style="color: #f87171;">Refusé</span></p>
        <p style="font-size: 0.75rem;">Postulé le 01/03/2026</p>
        <a href="detail-candidature.php?id=3" class="lien-etendu">Voir le détail</a>
      </article>
  </div>

  <nav aria-label="Pagination des candidatures" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5; cursor: not-allowed;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px; background: var(--accent-blue);">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">3</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>