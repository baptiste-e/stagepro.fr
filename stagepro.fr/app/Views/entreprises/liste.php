<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
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
        <article class="card" style="position: relative; min-height: 290px; display: flex; flex-direction: column; justify-content: space-between;">
          
          <div>
            <h3 style="color: var(--accent-blue); margin-bottom: 1rem;">
              <?= htmlspecialchars($entreprise['nom']) ?>
            </h3>

            <p style="line-height: 1.7; color: var(--text-main); margin-bottom: 1rem;">
              <?php
                $description = trim($entreprise['description'] ?? '');
                if ($description === '') {
                    echo 'Aucune description disponible.';
                } else {
                    echo htmlspecialchars(
                        mb_strlen($description) > 150
                            ? mb_substr($description, 0, 150) . '...'
                            : $description
                    );
                }
              ?>
            </p>

            <?php if (!empty($entreprise['email_contact'])): ?>
              <p style="margin-bottom: 0.4rem;">
                <strong>Email :</strong> <?= htmlspecialchars($entreprise['email_contact']) ?>
              </p>
            <?php endif; ?>

            <?php if (!empty($entreprise['telephone_contact'])): ?>
              <p style="margin-bottom: 0.4rem;">
                <strong>Téléphone :</strong> <?= htmlspecialchars($entreprise['telephone_contact']) ?>
              </p>
            <?php endif; ?>

            <p style="color: var(--text-muted); margin-top: 0.8rem; font-weight: 600;">
              Nombre d’offres : <?= (int)($entreprise['nb_offres'] ?? 0) ?>
            </p>
          </div>

          <div style="margin-top: 1.2rem;">
            <span style="color: var(--accent-blue); font-weight: 600;">Voir la fiche →</span>
          </div>

          <a href="index.php?page=entreprise-detail&id=<?= (int)$entreprise['id'] ?>" class="lien-etendu"></a>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune entreprise trouvée.</p>
    <?php endif; ?>
  </div>
</section>