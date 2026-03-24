<?php 
  $titre_page = "Indicateurs & Statistiques | StagePro";
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
<a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
<a href="index.php?page=offres" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);">Statistiques</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Tableau de bord des offres</h1>
  <p style="color: var(--text-muted);">Analyse globale des indicateurs de performance de la plateforme (SFx11).</p>
</section>

<section style="margin-top: 3rem;">
  <div class="container-espaces" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
    
    <article class="card" style="border-top: 4px solid var(--accent-blue);">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Offres disponibles</h3>
      <p style="font-size: 2.5rem; font-weight: 800; margin: 1rem 0; color: var(--text-main);">142</p>
      <p style="font-size: 0.8rem; color: #4ade80;">+12% depuis le mois dernier</p>
    </article>

    <article class="card" style="border-top: 4px solid var(--accent-purple);">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Moyenne candidatures</h3>
      <p style="font-size: 2.5rem; font-weight: 800; margin: 1rem 0; color: var(--text-main);">8.4</p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">par offre de stage</p>
    </article>

    <article class="card" style="border-top: 4px solid #fbbf24;">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Top Wish-list</h3>
      <p style="font-size: 1.1rem; font-weight: 600; margin: 1rem 0; color: var(--accent-blue);">Développeur Web @TechCorp</p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">Ajoutée 45 fois</p>
    </article>

    <article class="card" style="border-top: 4px solid #f87171;">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Durée moyenne</h3>
      <p style="font-size: 2.5rem; font-weight: 800; margin: 1rem 0; color: var(--text-main);">4.2</p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">mois par stage</p>
    </article>

  </div>
</section>

<section style="margin-top: 4rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 2rem; font-size: 1.2rem;">Répartition par durée</h2>
  <div style="height: 200px; display: flex; align-items: flex-end; gap: 20px; padding: 20px; border-left: 2px solid var(--border); border-bottom: 2px solid var(--border);">
    <div style="width: 40px; height: 30%; background: var(--accent-blue); border-radius: 4px 4px 0 0;" title="2 mois"></div>
    <div style="width: 40px; height: 60%; background: var(--accent-purple); border-radius: 4px 4px 0 0;" title="4 mois"></div>
    <div style="width: 40px; height: 90%; background: var(--accent-blue); border-radius: 4px 4px 0 0;" title="6 mois"></div>
    <div style="width: 40px; height: 45%; background: var(--accent-purple); border-radius: 4px 4px 0 0;" title="+6 mois"></div>
  </div>
  <div style="display: flex; gap: 20px; margin-top: 10px; padding-left: 20px; font-size: 0.7rem; color: var(--text-muted);">
    <span style="width: 40px; text-align: center;">2m</span>
    <span style="width: 40px; text-align: center;">4m</span>
    <span style="width: 40px; text-align: center;">6m</span>
    <span style="width: 40px; text-align: center;">+6m</span>
  </div>
</section>

<div style="margin-top: 3rem; text-align: center;">
    <a href="offres.php" style="color: var(--accent-blue); text-decoration: none; font-size: 0.9rem;">
        ← Retourner à la liste des offres
    </a>
</div>

