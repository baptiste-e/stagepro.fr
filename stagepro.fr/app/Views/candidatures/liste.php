<section>
  <h1><?= htmlspecialchars($titre_page ?? 'Candidatures') ?></h1>
  <p style="color: var(--text-muted);">
    Consultez les candidatures envoyées sur la plateforme.
  </p>
</section>

<section style="margin-top: 2rem;">
  <?php if (empty($candidatures)): ?>
    <div class="card">
      <p>Aucune candidature trouvée.</p>
    </div>
  <?php else: ?>
    <div class="container-espaces" style="margin-top: 1.5rem;">
      <?php foreach ($candidatures as $candidature): ?>
        <article class="card">
          <h3 style="color: var(--accent-blue);">
            <?= htmlspecialchars($candidature['offre_titre']) ?>
          </h3>

          <p>
            <strong>Entreprise :</strong>
            <?= htmlspecialchars($candidature['entreprise_nom']) ?>
          </p>

          <?php if (!empty($candidature['etudiant_prenom']) || !empty($candidature['etudiant_nom'])): ?>
            <p>
              <strong>Étudiant :</strong>
              <?= htmlspecialchars(trim(($candidature['etudiant_prenom'] ?? '') . ' ' . ($candidature['etudiant_nom'] ?? ''))) ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($candidature['etudiant_email'])): ?>
            <p>
              <strong>Email :</strong>
              <?= htmlspecialchars($candidature['etudiant_email']) ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($candidature['lettre_motivation'])): ?>
            <p style="margin-top: 0.75rem;">
              <strong>Lettre de motivation :</strong><br>
              <?= nl2br(htmlspecialchars($candidature['lettre_motivation'])) ?>
            </p>
          <?php endif; ?>

          <p style="margin-top: 0.75rem;">
            <strong>CV :</strong>
            <?php if (!empty($candidature['cv'])): ?>
              <a href="<?= htmlspecialchars($candidature['cv']) ?>" target="_blank">Voir le CV</a>
            <?php else: ?>
              Non disponible
            <?php endif; ?>
          </p>

          <p style="margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
            Envoyée le <?= htmlspecialchars($candidature['created_at']) ?>
          </p>

          <a href="index.php?page=candidature-detail&id=<?= (int) $candidature['id'] ?>" class="lien-etendu"></a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>