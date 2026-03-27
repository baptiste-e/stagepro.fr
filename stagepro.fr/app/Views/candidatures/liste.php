<?php
$role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');

function badgeStatut($statut) {
    switch ($statut) {
        case 'acceptee':
            return ['label' => 'Acceptée', 'bg' => '#dcfce7', 'color' => '#166534'];
        case 'refusee':
            return ['label' => 'Refusée', 'bg' => '#fee2e2', 'color' => '#991b1b'];
        default:
            return ['label' => 'En attente', 'bg' => '#fef3c7', 'color' => '#92400e'];
    }
}
?>

<section>
  <h1><?= in_array($role, ['admin', 'pilote'], true) ? 'Gestion des candidatures' : 'Mes candidatures' ?></h1>
  <p style="color: var(--text-muted);">
    <?= in_array($role, ['admin', 'pilote'], true)
        ? "Retrouvez ici l’ensemble des candidatures déposées sur la plateforme."
        : "Retrouvez ici les offres auxquelles vous avez postulé et le détail de vos dossiers envoyés." ?>
  </p>
</section>

<section style="margin-top: 2rem;">
  <?php if (empty($candidatures)): ?>
    <div style="background: var(--surface); padding: 2rem; border-radius: 8px; text-align: center; border: 1px solid var(--border);">
      <p>Aucune candidature trouvée.</p>
      <?php if ($role === 'etudiant'): ?>
        <a href="index.php?page=offres" class="btn-cta" style="display: inline-block; margin-top: 1rem; text-decoration: none;">Voir les offres disponibles</a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="container-espaces" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
      <?php foreach ($candidatures as $c): ?>
        <?php $badge = badgeStatut($c['statut'] ?? 'en_attente'); ?>
        <article class="card" style="position: relative; transition: transform 0.2s; border: 1px solid var(--border); padding: 1.5rem; border-radius: 12px; background: var(--surface);">

          <div style="display: flex; justify-content: space-between; gap: 1rem; align-items: flex-start;">
            <h3 style="color: var(--accent-blue); margin-bottom: 0.5rem;">
              <?= htmlspecialchars($c['offre_titre']) ?>
            </h3>

            <span style="background: <?= $badge['bg'] ?>; color: <?= $badge['color'] ?>; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">
              <?= $badge['label'] ?>
            </span>
          </div>

          <p style="margin-bottom: 0.5rem;">
            <strong>Entreprise :</strong> <?= htmlspecialchars($c['entreprise_nom']) ?>
          </p>

          <?php if (in_array($role, ['admin', 'pilote'], true)): ?>
            <p style="margin-bottom: 0.5rem;">
              <strong>Candidat :</strong>
              <?= htmlspecialchars(($c['etudiant_prenom'] ?? '') . ' ' . ($c['etudiant_nom'] ?? '')) ?>
            </p>
          <?php endif; ?>

          <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
            📅 Envoyée le <?= date('d/m/Y à H:i', strtotime($c['created_at'])) ?>
          </p>

          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <span style="font-size: 0.8rem; font-weight: bold; color: var(--accent-blue); text-transform: uppercase;">
              Voir le détail &rarr;
            </span>
          </div>

          <a href="index.php?page=candidature-detail&id=<?= (int)$c['id'] ?>" class="lien-etendu" title="Voir les détails de la candidature"></a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: var(--accent-blue);
}

.lien-etendu {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>