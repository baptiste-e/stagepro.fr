<?php 
  $titre_page = "Suivi Candidatures (Pilote) | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Candidatures (Pilote)</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Candidatures des étudiants</h1>
  <p style="color: var(--text-muted);">Gestion et suivi des offres postulées par vos étudiants (SFx22).</p>
</section>

<section style="margin-top: 2rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Liste des candidatures rattachées</h2>
    <select style="padding: 5px; background: var(--surface); color: var(--text-main); border: 1px solid var(--border); border-radius: 4px;">
      <option>Tous les étudiants</option>
      <option>Promotion A2</option>
      <option>Promotion A3</option>
    </select>
  </div>

  <div class="container-espaces">
      <article class="card">
        <h3 style="color: var(--accent-blue);">Jean Dupont</h3>
        <p><strong>Offre :</strong> Développeur Web</p>
        <p><strong>Entreprise :</strong> TechCorp</p>
        <p><strong>État :</strong> <span style="color: #fbbf24;">En attente</span></p>
        <a href="detail-candidature.php?id=1" class="lien-etendu"></a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">Alice Martin</h3>
        <p><strong>Offre :</strong> Data Analyst</p>
        <p><strong>Entreprise :</strong> DataFlow</p>
        <p><strong>État :</strong> <span style="color: #4ade80;">Validée par Pilote</span></p>
        <a href="detail-candidature.php?id=2" class="lien-etendu"></a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">Marc Durand</h3>
        <p><strong>Offre :</strong> Cyber Sécurité</p>
        <p><strong>Entreprise :</strong> SafeNet</p>
        <p><strong>État :</strong> <span style="color: #f87171;">Refusée</span></p>
        <a href="detail-candidature.php?id=3" class="lien-etendu"></a>
      </article>
  </div>

  <nav aria-label="Pagination des candidatures" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>