<section>
  <h1>Annuaire des entreprises</h1>
  <div class="container-espaces" style="margin-top: 1.5rem;">
    <?php foreach ($entreprises as $entreprise): ?>
      <article class="card">
        <h3><?= htmlspecialchars($entreprise['nom']) ?></h3>
        <p><?= htmlspecialchars($entreprise['description'] ?? 'Aucune description.') ?></p>
        <a href="index.php?page=entreprise-detail&id=<?= (int)$entreprise['id'] ?>" class="lien-etendu"></a>
      </article>
    <?php endforeach; ?>
  </div>
</section>