<?php
$isEdit = isset($entreprise) && !empty($entreprise['id']);
?>

<div style="padding: 2rem; max-width: 900px; margin: 0 auto;">
    <nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
      <p>
        <a href="index.php?page=home" style="color: #2563eb;">Accueil</a> &gt;
        <a href="index.php?page=entreprises" style="color: #2563eb;">Entreprises</a> &gt;
        <span style="color: #666;"><?= $isEdit ? 'Modification' : 'Création' ?></span>
      </p>
    </nav>

    <header style="margin-bottom: 2rem;">
      <h1 style="font-size: 2rem; color: #1e293b; margin-bottom: 0.5rem;">
        <?= $isEdit ? "Modifier l'entreprise" : "Ajouter une entreprise" ?>
      </h1>
      <p style="color: #64748b;">
        <?= $isEdit ? "Mettez à jour les informations de l'entreprise partenaire." : "Remplissez le formulaire pour référencer une nouvelle entreprise." ?>
      </p>
    </header>

    <form action="index.php?page=<?= $isEdit ? 'entreprise-update' : 'entreprise-save' ?>" method="post" 
          style="background: #ffffff; padding: 2.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= (int)$entreprise['id'] ?>">
        <?php endif; ?>

        <div style="margin-bottom: 1.5rem;">
          <label for="nom" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Nom de l'entreprise *</label>
          <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>" required 
                 style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 1rem;">
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label for="description" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Description / Secteur d'activité</label>
          <textarea id="description" name="description" rows="5" 
                    style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 1rem; font-family: inherit;"><?= htmlspecialchars($entreprise['description'] ?? '') ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
              <label for="email_contact" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Email de contact</label>
              <input type="email" id="email_contact" name="email_contact" value="<?= htmlspecialchars($entreprise['email_contact'] ?? '') ?>" 
                     style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #cbd5e1;">
            </div>
            <div>
              <label for="telephone_contact" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155;">Téléphone</label>
              <input type="text" id="telephone_contact" name="telephone_contact" value="<?= htmlspecialchars($entreprise['telephone_contact'] ?? '') ?>" 
                     style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #cbd5e1;">
            </div>
        </div>

        <div style="padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; flex-direction: row-reverse; gap: 1rem; align-items: center;">
          <button type="submit" 
                  style="background-color: #2563eb; color: #ffffff; padding: 0.8rem 2rem; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: background 0.2s;">
            <?= $isEdit ? "Enregistrer les modifications" : "Créer l'entreprise" ?>
          </button>
          
          <a href="index.php?page=entreprises" 
             style="text-decoration: none; color: #64748b; font-weight: 500; font-size: 1rem; padding: 0.8rem 1rem;">
            Annuler
          </a>
        </div>

    </form>
</div>