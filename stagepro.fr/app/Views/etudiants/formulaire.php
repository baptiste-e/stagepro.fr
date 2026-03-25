<?php
// On vérifie si on est en mode édition
$isEdit = isset($etudiant) && !empty($etudiant);
$title = $isEdit ? "Modifier l'étudiant" : "Créer un étudiant";
?>

<section>
  <nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
    <p>
      <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
      <a href="index.php?page=etudiants" style="color: var(--accent-blue);">Étudiants</a> &gt;
      <span style="color: var(--text-muted);"><?= $isEdit ? 'Édition' : 'Création' ?></span>
    </p>
  </nav>

  <h1><?= $title ?></h1>
  <p style="color: var(--text-muted);"><?= $isEdit ? "Modifiez les informations de ce compte." : "Ajoutez un nouveau compte étudiant." ?></p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=etudiant-save" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <input type="hidden" name="id" value="<?= $isEdit ? (int)$etudiant['id'] : 0 ?>">

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="nom" style="display: block; margin-bottom: 0.5rem;">Nom</label>
      <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom'] ?? '') ?>" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="prenom" style="display: block; margin-bottom: 0.5rem;">Prénom</label>
      <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom'] ?? '') ?>" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($etudiant['email'] ?? '') ?>" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="password" style="display: block; margin-bottom: 0.5rem;">
        Mot de passe <?= $isEdit ? "(laisser vide pour ne pas changer)" : "" ?>
      </label>
      <input type="password" id="password" name="password" <?= $isEdit ? "" : "required" ?> style="width: 100%; padding: 0.5rem;">
    </div>

    <div style="margin-top: 2rem;">
      <button type="submit" class="btn-cta"><?= $isEdit ? "Mettre à jour" : "Enregistrer l'étudiant" ?></button>
      <a href="index.php?page=etudiants" style="margin-left: 1rem; color: var(--text-muted); text-decoration: none;">Annuler</a>
    </div>

  </form>
</section>