<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des étudiants</h1>
      <p style="color: var(--text-muted);">Gérez les comptes et suivez l'avancement des recherches.</p>
    </div>

    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'])): ?>
      <a href="index.php?page=etudiant-create" class="btn-cta" style="font-size: 0.85rem;">+ Créer un étudiant</a>
    <?php endif; ?>
  </div>
</section>

<section style="margin-top: 3rem;">
  <h2>Liste des étudiants</h2>
  <div class="container-espaces" style="margin-top: 1.5rem;">
    <?php foreach ($etudiants as $etudiant): ?>
        <article class="card">
          <h3><?= htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']) ?></h3>
          <p><?= htmlspecialchars($etudiant['email']) ?></p>
          <a href="index.php?page=etudiant-detail&id=<?= $etudiant['id'] ?>" class="lien-etendu"></a>
        </article>
    <?php endforeach; ?>
  </div>
</section>