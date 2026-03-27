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
                        <?= htmlspecialchars($candidature['offre_titre']) ?>
                    </h3>

                    <p><strong>Entreprise :</strong> <?= htmlspecialchars($candidature['entreprise_nom']) ?></p>

                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.75rem;">
                        <strong>Candidature envoyée le :</strong>
                        <?= !empty($candidature['created_at']) ? date('d/m/Y à H:i', strtotime($candidature['created_at'])) : 'Non renseigné' ?>
                    </p>

                    <div style="margin-top: 1rem; display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="index.php?page=candidature-detail&id=<?= (int)$candidature['id'] ?>" class="btn-cta" style="font-size: 0.8rem;">
                            Voir le détail
                        </a>

                        <form action="index.php?page=candidature-cancel&id=<?= (int)$candidature['id'] ?>" method="post" onsubmit="return confirm('Annuler cette candidature ?');">
                            <button type="submit" style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 6px 12px; font-size: 0.8rem; cursor: pointer;">
                                Annuler
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>