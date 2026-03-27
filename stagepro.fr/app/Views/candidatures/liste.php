<?php
/**
 * VUE : Liste des candidatures
 * Variables attendues :
 * - $candidatures
 * - $titre_page
 */
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Mes candidatures</span>
  </p>
</nav>

<section>
<h1>Mes candidatures</h1>
    <p style="color: var(--text-muted); margin-bottom: 2rem;">
        Suivez ici l’ensemble des offres auxquelles vous avez postulé.
    </p>

    <?php if (empty($candidatures)): ?>
        <div style="background: var(--surface); padding: 2rem; border-radius: 12px; border: 1px dashed var(--border);">
            <p style="margin: 0;">Vous n’avez encore envoyé aucune candidature.</p>
        </div>
    <?php else: ?>
        <div class="container-espaces">
            <?php foreach ($candidatures as $candidature): ?>
                <article class="card">
                    <h3 style="color: var(--accent-blue);">
                        <?= htmlspecialchars($candidature['offre_titre'] ?? 'Offre non renseignée') ?>
                    </h3>

                    <p>
                        <strong>Entreprise :</strong>
                        <?= htmlspecialchars($candidature['entreprise_nom'] ?? 'Entreprise non renseignée') ?>
                    </p>

                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.75rem;">
                        <strong>Candidature envoyée le :</strong>
                        <?= !empty($candidature['created_at']) ? date('d/m/Y à H:i', strtotime($candidature['created_at'])) : 'Non renseigné' ?>
                    </p>

                    <div style="margin-top: 1rem; display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="index.php?page=candidature-detail&id=<?= (int)($candidature['id'] ?? 0) ?>" class="btn-cta" style="font-size: 0.8rem;">
                            Voir le détail
                        </a>

                        <form action="index.php?page=candidature-cancel&id=<?= (int)($candidature['id'] ?? 0) ?>" method="post" onsubmit="return confirm('Annuler cette candidature ?');">
                            <button type="submit" style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 6px 12px; font-size: 0.8rem; cursor: pointer;">
                                Annuler
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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