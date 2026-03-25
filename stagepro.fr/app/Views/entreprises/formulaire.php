<?php
$modeEdition = isset($entreprise) && !empty($entreprise['id']);
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=entreprises" style="color: var(--accent-blue);">Entreprises</a> &gt;
    <span style="color: var(--text-muted);">
      <?= $modeEdition ? 'Modification' : 'Création' ?>
    </span>
  </p>
</nav>

<section>
  <h1><?= $modeEdition ? "Modifier l'entreprise" : "Créer une entreprise" ?></h1>
  <p style="color: var(--text-muted);">
    <?= $modeEdition ? "Modifiez les informations de l'entreprise." : "Ajoutez une nouvelle entreprise partenaire." ?>
  </p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=<?= $modeEdition ? 'entreprise-update' : 'entreprise-save' ?>" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <?php if ($modeEdition): ?>
      <input type="hidden" name="id" value="<?= (int)$entreprise['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" rows="6"><?= htmlspecialchars($entreprise['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
      <label for="email_contact">Email</label>
      <input type="email" id="email_contact" name="email_contact" value="<?= htmlspecialchars($entreprise['email_contact'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label for="telephone_contact">Téléphone</label>
      <input type="text" id="telephone_contact" name="telephone_contact" value="<?= htmlspecialchars($entreprise['telephone_contact'] ?? '') ?>">
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem; align-items: center;">
      <button type="submit"><?= $modeEdition ? "Enregistrer les modifications" : "Créer l'entreprise" ?></button>
      <a href="index.php?page=entreprises" style="color: var(--text-muted); text-decoration: none;">Annuler</a>
    </div>

  </form>
</section>