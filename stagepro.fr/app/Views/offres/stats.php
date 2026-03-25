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
  <p style="color: var(--text-muted);">Analyse globale des indicateurs de la plateforme.</p>
</section>

<section style="margin-top: 3rem;">
  <div class="container-espaces" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
    
    <article class="card" style="border-top: 4px solid var(--accent);">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Offres disponibles</h3>
      <p style="font-size: 2.5rem; font-weight: 800; margin: 1rem 0; color: var(--text-main);">
        <?= (int)($totalOffres ?? 0) ?>
      </p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">Total des offres enregistrées</p>
    </article>

    <article class="card" style="border-top: 4px solid #7c3aed;">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Localité la plus active</h3>
      <p style="font-size: 1.3rem; font-weight: 700; margin: 1rem 0; color: var(--text-main);">
        <?= htmlspecialchars($topLocalite['localite'] ?? 'Aucune donnée') ?>
      </p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">
        <?= isset($topLocalite['nb']) ? (int)$topLocalite['nb'] . ' offre(s)' : '0 offre' ?>
      </p>
    </article>

    <article class="card" style="border-top: 4px solid #f59e0b;">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Entreprise la plus active</h3>
      <p style="font-size: 1.1rem; font-weight: 700; margin: 1rem 0; color: var(--text-main);">
        <?= htmlspecialchars($topEntreprise['nom'] ?? 'Aucune donnée') ?>
      </p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">
        <?= isset($topEntreprise['nb']) ? (int)$topEntreprise['nb'] . ' offre(s)' : '0 offre' ?>
      </p>
    </article>

    <article class="card" style="border-top: 4px solid #ef4444;">
      <h3 style="font-size: 0.9rem; color: var(--text-muted); text-transform: uppercase;">Entreprises avec offres</h3>
      <p style="font-size: 2.5rem; font-weight: 800; margin: 1rem 0; color: var(--text-main);">
        <?= (int)($nbEntreprisesAvecOffres ?? 0) ?>
      </p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">Sur <?= count($statsEntreprise ?? []) ?> entreprise(s)</p>
    </article>

  </div>
</section>

<section style="margin-top: 4rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Répartition par localité</h2>

  <?php if (!empty($statsLocalite)): ?>
    <div style="display: grid; gap: 1rem;">
      <?php foreach ($statsLocalite as $ligne): ?>
        <div style="display: grid; grid-template-columns: 180px 1fr 60px; gap: 1rem; align-items: center;">
          <div style="font-weight: 600; color: var(--text-main);">
            <?= htmlspecialchars($ligne['localite'] ?: 'Non renseigné') ?>
          </div>
          <div style="background: #e5e7eb; height: 14px; border-radius: 999px; overflow: hidden;">
            <div style="height: 14px; width: <?= $totalOffres > 0 ? max(4, round(((int)$ligne['nb'] / $totalOffres) * 100)) : 0 ?>%; background: var(--accent); border-radius: 999px;"></div>
          </div>
          <div style="text-align: right; color: var(--text-muted); font-size: 0.9rem;">
            <?= (int)$ligne['nb'] ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="color: var(--text-muted);">Aucune donnée disponible.</p>
  <?php endif; ?>
</section>

<section style="margin-top: 3rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Répartition par entreprise</h2>

  <?php if (!empty($statsEntreprise)): ?>
    <div style="display: grid; gap: 1rem;">
      <?php foreach ($statsEntreprise as $ligne): ?>
        <?php if ((int)$ligne['nb'] > 0): ?>
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.9rem 1rem; border: 1px solid var(--border); border-radius: 8px;">
            <span style="font-weight: 600;"><?= htmlspecialchars($ligne['nom']) ?></span>
            <span style="color: var(--text-muted);"><?= (int)$ligne['nb'] ?> offre(s)</span>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="color: var(--text-muted);">Aucune donnée disponible.</p>
  <?php endif; ?>
</section>

<div style="margin-top: 3rem; text-align: center;">
  <a href="index.php?page=offres" class="btn-cta">Retour à la liste des offres</a>
</div>