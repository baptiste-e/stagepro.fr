<?php
$isEdit = isset($modeEdition) && $modeEdition === true && !empty($offre);
$dateOffreValue = htmlspecialchars($offre['date_offre'] ?? date('Y-m-d'));
?>

<section style="margin-top: 2rem;">
  <form action="index.php?page=offre-save" method="post" style="max-width: 900px; background: var(--surface); padding: 2.5rem; border-radius: 8px; border: 1px solid var(--border);">

    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= (int) $offre['id'] ?>">
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        <div class="form-group" style="grid-column: span 2;">
          <label for="titre">Intitulé du poste</label>
          <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($offre['titre'] ?? '') ?>" placeholder="Ex: Développeur Web Fullstack H/F" required>
        </div>

        <div class="form-group">
          <label for="id_entreprise">Entreprise</label>
          <select id="id_entreprise" name="id_entreprise" required>
            <option value="">-- Sélectionnez une entreprise --</option>
            <?php foreach ($entreprises as $entreprise): ?>
              <option value="<?= (int) $entreprise['id'] ?>"
                <?= (isset($offre['entreprise_id']) && (int) $offre['entreprise_id'] === (int) $entreprise['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($entreprise['nom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="date_offre">Date de publication</label>
          <input type="date" id="date_offre" name="date_offre" value="<?= $dateOffreValue ?>" required>
        </div>

        <div class="form-group">
          <label for="localite">Ville / Lieu</label>
          <input type="text" id="localite" name="localite" value="<?= htmlspecialchars($offre['localite'] ?? '') ?>" placeholder="Ex: Lyon (69)">
        </div>

        <div class="form-group">
          <label for="duree">Durée du stage</label>
          <input type="text" id="duree" name="duree" value="<?= htmlspecialchars($offre['duree'] ?? '') ?>" placeholder="Ex: 4 à 6 mois">
        </div>

        <div class="form-group">
          <label for="nb_places">Nombre de places</label>
          <input type="number" id="nb_places" name="nb_places" min="1" value="<?= htmlspecialchars($offre['nb_places'] ?? '1') ?>" required>
        </div>

        <div class="form-group">
          <label for="remuneration">Gratification mensuelle (€)</label>
          <input type="number" id="remuneration" name="remuneration" min="0" step="0.01" value="<?= htmlspecialchars($offre['remuneration'] ?? '') ?>" placeholder="Ex: 600">
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="competences">Tags / Compétences clés</label>
          <input type="text" id="competences" name="competences" value="<?= htmlspecialchars($offre['competences'] ?? '') ?>" placeholder="React, PHP, Docker...">
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="description">Description détaillée des missions</label>
          <textarea id="description" name="description" rows="8" placeholder="Décrivez les projets..." required><?= htmlspecialchars($offre['description'] ?? '') ?></textarea>
        </div>

    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit"><?= $isEdit ? "Mettre à jour l'offre" : "Enregistrer l'offre" ?></button>
      <a href="index.php?page=offres" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>