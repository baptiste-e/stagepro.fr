<section>
  <h1>Mes candidatures</h1>
  <p style="color: var(--text-muted);">Retrouvez ici les offres auxquelles vous avez postulé.</p>
</section>

<section style="margin-top: 2rem;">
  <?php if (empty($candidatures)): ?>
    <p>Vous n'avez encore postulé à aucune offre. <a href="index.php?page=offres">Voir les offres</a></p>
  <?php else: ?>
    <div class="container-espaces">
      <?php foreach ($candidatures as $c): ?>
        <article class="card">
          <h3 style="color: var(--accent-blue);"><?= htmlspecialchars($c['offre_titre']) ?></h3>
          <p><strong>Entreprise :</strong> <?= htmlspecialchars($c['entreprise_nom']) ?></p>
          <p style="font-size: 0.85rem; color: var(--text-muted);">Envoyée le <?= $c['created_at'] ?></p>
          <a href="index.php?page=offre-detail&id=<?= $c['offre_id'] ?>" class="lien-etendu"></a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>