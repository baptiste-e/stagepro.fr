<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des entreprises</h1>
      <p style="color: var(--text-muted);">Trouvez votre futur lieu de stage parmi nos partenaires.</p>
    </div>

    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'], true)): ?>
      <a href="index.php?page=entreprise-create" class="btn-cta" style="font-size: 0.85rem;">+ Créer une entreprise</a>
    <?php endif; ?>
  </div>
</section>

<section style="margin-top: 3rem;">
  <h2>Entreprises partenaires</h2>

  <div class="container-espaces" style="margin-top: 1.5rem;">
    <?php if (!empty($entreprises)): ?>
      <?php foreach ($entreprises as $entreprise): ?>
        <article class="card">
          <h3 style="color: var(--accent-blue);">
            <?= htmlspecialchars($entreprise['nom']) ?>
          </h3>

          <p>
            <?= htmlspecialchars($entreprise['description'] ?? 'Aucune description disponible.') ?>
          </p>

          <?php if (!empty($entreprise['email_contact'])): ?>
            <p><strong>Email :</strong> <?= htmlspecialchars($entreprise['email_contact']) ?></p>
          <?php endif; ?>

          <?php if (!empty($entreprise['telephone_contact'])): ?>
            <p><strong>Téléphone :</strong> <?= htmlspecialchars($entreprise['telephone_contact']) ?></p>
          <?php endif; ?>

          <p style="font-size: 0.85rem; color: var(--text-muted);">
            <strong>Créée le :</strong>
            <?= !empty($entreprise['created_at']) ? date('d/m/Y à H:i', strtotime($entreprise['created_at'])) : 'Non renseignée' ?>
          </p>

          <a href="index.php?page=entreprise-detail&id=<?= (int)$entreprise['id'] ?>" class="lien-etendu"></a>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune entreprise trouvée.</p>
    <?php endif; ?>
  </div>
</section>