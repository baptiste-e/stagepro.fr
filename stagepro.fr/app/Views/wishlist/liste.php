<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Ma wish-list</span>
  </p>
</nav>

<section>
    <?php if ($wishlist_est_vide): ?>
        <div style="background: var(--surface); padding: 3rem; border-radius: 12px; border: 1px dashed var(--border); text-align: center;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">⭐</div>
            <h1>Votre wish-list est vide</h1>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Parcourez le catalogue pour trouver des opportunités !</p>
            <a href="index.php?page=offres" class="btn-cta">Explorer les offres</a>
        </div>
    <?php else: ?>
        <h1>Ma wish-list</h1>
        <div class="container-espaces" style="margin-top: 2rem;">
            <?php foreach ($wishlist as $item): ?>
                <article class="card">
                    <h3 style="color: var(--accent-blue);"><?= htmlspecialchars($item['titre']) ?></h3>
                    <p><strong>Entreprise :</strong> <?= htmlspecialchars($item['entreprise_nom']) ?></p>

                    <?php if (!empty($item['wishlist_created_at'])): ?>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">
                            <strong>Ajoutée le :</strong>
                            <?= date('d/m/Y à H:i', strtotime($item['wishlist_created_at'])) ?>
                        </p>
                    <?php endif; ?>

                    <div style="margin-top: 1rem; display: flex; gap: 10px;">
                        <a href="index.php?page=offre-detail&id=<?= $item['id'] ?>" class="btn-cta" style="font-size: 0.75rem;">Voir</a>
                        <form action="index.php?page=wishlist-remove" method="post">
                            <input type="hidden" name="id_offre" value="<?= $item['id'] ?>">
                            <button type="submit" style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 5px 10px; font-size: 0.75rem; cursor: pointer;">Retirer</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>