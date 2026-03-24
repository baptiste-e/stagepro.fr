<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des pilotes</h1>
      <p style="color: var(--text-muted);">Gérez les comptes des tuteurs et responsables de promotion.</p>
    </div>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
      <a href="index.php?page=pilote-create" class="btn-cta" style="font-size: 0.85rem;">+ Créer un pilote</a>
    <?php endif; ?>
  </div>
</section>

<section style="margin-top: 3rem;">
  <h2>Pilotes enregistrés</h2>
  <div class="container-espaces" style="margin-top: 1.5rem;">
    <?php foreach ($pilotes as $p): ?>
        <article class="card">
          <h3><?= htmlspecialchars($p['prenom'] . ' ' . $p['nom']) ?></h3>
          <p><strong>Email :</strong> <?= htmlspecialchars($p['email']) ?></p>
          <a href="index.php?page=pilote-detail&id=<?= $p['id'] ?>" class="lien-etendu"></a>
        </article>
    <?php endforeach; ?>
  </div>
</section>