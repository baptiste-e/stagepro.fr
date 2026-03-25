<?php
// On vérifie si on est en mode édition (chargé par la méthode edit du contrôleur)
$isEdit = isset($modeEdition) && $modeEdition === true && isset($pilote);
$actionTitle = $isEdit ? "Modifier le pilote" : "Créer un pilote";
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=pilotes" style="color: var(--accent-blue);">Pilotes</a> &gt;
    <span style="color: var(--text-muted);"><?= $isEdit ? 'Édition' : 'Création' ?></span>
  </p>
</nav>

<section>
  <h1><?= $actionTitle ?></h1>
  <p style="color: var(--text-muted);">
    <?= $isEdit ? "Modifiez les informations du compte pilote." : "Ajoutez un nouveau compte pilote pour la gestion des promotions." ?>
  </p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=pilote-save" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <input type="hidden" name="id" value="<?= $isEdit ? (int)$pilote['id'] : 0 ?>">

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="nom" style="display: block; margin-bottom: 0.5rem;">Nom</label>
      <input type="text" id="nom" name="nom" 
             value="<?= htmlspecialchars($pilote['nom'] ?? '') ?>" 
             placeholder="Ex: Martin" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="prenom" style="display: block; margin-bottom: 0.5rem;">Prénom</label>
      <input type="text" id="prenom" name="prenom" 
             value="<?= htmlspecialchars($pilote['prenom'] ?? '') ?>" 
             placeholder="Ex: Jean" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="email" style="display: block; margin-bottom: 0.5rem;">Email professionnel</label>
      <input type="email" id="email" name="email" 
             value="<?= htmlspecialchars($pilote['email'] ?? '') ?>" 
             placeholder="Ex: jmartin@cesi.fr" required style="width: 100%; padding: 0.5rem;">
    </div>

    <div class="form-group" style="margin-bottom: 1rem;">
      <label for="password" style="display: block; margin-bottom: 0.5rem;">
        Mot de passe <?= $isEdit ? "(laisser vide pour ne pas changer)" : "" ?>
      </label>
      <input type="password" id="password" name="password" 
             <?= $isEdit ? "" : "required" ?> style="width: 100%; padding: 0.5rem;">
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem; align-items: center;">
      <button type="submit" class="btn-cta"><?= $isEdit ? "Mettre à jour" : "Enregistrer le pilote" ?></button>
      <a href="index.php?page=pilotes" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>