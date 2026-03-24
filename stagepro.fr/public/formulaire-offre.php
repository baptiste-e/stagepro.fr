<?php
require 'includes/auth.php';
require 'includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'pilote'])) {
    die('Accès refusé.');
}

$sqlEntreprises = "SELECT id, nom FROM entreprises ORDER BY nom ASC";
$resultatEntreprises = $pdo->query($sqlEntreprises);
$entreprises = $resultatEntreprises->fetchAll(PDO::FETCH_ASSOC);

$offre = null;
$modeEdition = false;

if (isset($_GET['id']) && (int) $_GET['id'] > 0) {
    $modeEdition = true;
    $id = (int) $_GET['id'];

    $sqlOffre = "SELECT * FROM offres WHERE id = :id";
    $stmtOffre = $pdo->prepare($sqlOffre);
    $stmtOffre->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtOffre->execute();

    $offre = $stmtOffre->fetch(PDO::FETCH_ASSOC);

    if (!$offre) {
        die('Offre introuvable.');
    }
}

$titre_page = $modeEdition ? "Modifier une offre | StagePro" : "Gestion Offre | StagePro";
include 'includes/header.php';
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="offres.php" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);"><?= $modeEdition ? 'Modification' : 'Création' ?></span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;"><?= $modeEdition ? 'Modifier une offre' : 'Publier une offre' ?></h1>
  <p style="color: var(--text-muted);">Décrivez le poste et les compétences attendues pour attirer les meilleurs candidats.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-offre.php" method="post" style="max-width: 900px; background: var(--surface); padding: 2.5rem; border-radius: 8px; border: 1px solid var(--border);">

    <?php if ($modeEdition): ?>
      <input type="hidden" name="id" value="<?= (int) $offre['id'] ?>">
    <?php endif; ?>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        
        <div class="form-group" style="grid-column: span 2;">
          <label for="titre">Intitulé du poste</label>
          <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($offre['titre'] ?? '') ?>" placeholder="Ex: Développeur Web Fullstack H/F" required>
        </div>

        <div class="form-group">
          <label for="entreprise_id">Entreprise</label>
          <select id="entreprise_id" name="entreprise_id" required>
            <option value="">-- Sélectionnez une entreprise --</option>
            <?php foreach ($entreprises as $entreprise): ?>
              <option value="<?= (int) $entreprise['id'] ?>"
                <?= isset($offre['entreprise_id']) && (int) $offre['entreprise_id'] === (int) $entreprise['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($entreprise['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="date">Date de début du stage</label>
          <input type="date" id="date" name="date" value="<?= htmlspecialchars($offre['date_offre'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label for="remuneration">Gratification mensuelle (€)</label>
          <input type="number" id="remuneration" name="remuneration" min="0" step="0.01" value="<?= htmlspecialchars($offre['remuneration'] ?? '') ?>" placeholder="Ex: 600">
        </div>

        <div class="form-group">
          <label for="competences">Tags / Compétences clés</label>
          <input type="text" id="competences" name="competences" placeholder="React, PHP, Docker...">
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="description">Description détaillée des missions</label>
          <textarea id="description" name="description" rows="8" placeholder="Décrivez les projets, l'environnement technique, l'équipe..." required><?= htmlspecialchars($offre['description'] ?? '') ?></textarea>
        </div>

    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit"><?= $modeEdition ? "Mettre à jour l'offre" : "Enregistrer l'offre" ?></button>
      <a href="offres.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>