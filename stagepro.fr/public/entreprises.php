<?php
require 'includes/db.php';

$sql = "SELECT * FROM entreprises";
$resultat = $pdo->query($sql);
$entreprises = $resultat->fetchAll(PDO::FETCH_ASSOC);

$titre_page = "Liste des Entreprises | StagePro";

include 'includes/header.php';
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des entreprises</h1>
      <p style="color: var(--text-muted);">Trouvez votre futur lieu de stage parmi nos partenaires.</p>
    </div>

    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'])): ?>
      <a href="formulaire-entreprise.php" class="btn-cta" style="font-size: 0.85rem;">+ Créer une entreprise</a>
    <?php endif; ?>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Filtres de recherche</h2>
  
  <form action="entreprises.php" method="get">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem;">
      
      <div class="form-group">
        <label for="nom">Nom / Mot-clé</label>
        <input type="search" id="nom" name="nom" placeholder="Ex: TechCorp">
      </div>

      <div class="form-group">
        <label for="ville">Ville</label>
        <input type="text" id="ville" name="ville" placeholder="Ex: Lyon">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="contact@...">
      </div>

      <div class="form-group">
        <label for="note">Note minimale</label>
        <select id="note" name="note">
          <option value="">Peu importe</option>
          <option value="4">⭐⭐⭐⭐ & plus</option>
          <option value="3">⭐⭐⭐ & plus</option>
          <option value="2">⭐⭐ & plus</option>
          <option value="1">⭐ & plus</option>
        </select>
      </div>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
      <button type="submit">Rechercher</button>
      <button type="reset" style="background: transparent; border: 1px solid var(--border); color: var(--text-muted);">Réinitialiser</button>
    </div>
  </form>
</section>

<section style="margin-top: 3rem;">
  <h2>Entreprises partenaires</h2>
  
  <div class="container-espaces" style="margin-top: 1.5rem;">
    <?php foreach ($entreprises as $entreprise): ?>
      <article class="card">
        <h3 style="color: var(--accent-blue);">
          <?= htmlspecialchars($entreprise['nom']) ?>
        </h3>

        <p>
          <?= htmlspecialchars($entreprise['description'] ?? 'Aucune description disponible.') ?>
        </p>

        <p><strong>Email :</strong> <?= htmlspecialchars($entreprise['email_contact'] ?? '-') ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($entreprise['telephone_contact'] ?? '-') ?></p>

        <a href="fiche-entreprise.php?id=<?= (int) $entreprise['id'] ?>" class="lien-etendu"></a>
      </article>
    <?php endforeach; ?>
  </div>

  <nav aria-label="Pagination" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>