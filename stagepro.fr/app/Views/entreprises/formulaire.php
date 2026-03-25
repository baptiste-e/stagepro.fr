<section>
  <h1>Créer une entreprise</h1>
  <p style="color: var(--text-muted);">Ajoutez une nouvelle entreprise partenaire.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=entreprise-save" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" rows="6"></textarea>
    </div>

    <div class="form-group">
      <label for="email_contact">Email</label>
      <input type="email" id="email_contact" name="email_contact">
    </div>

    <div class="form-group">
      <label for="telephone_contact">Téléphone</label>
      <input type="text" id="telephone_contact" name="telephone_contact">
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
      <button type="submit">Enregistrer</button>
      <a href="index.php?page=entreprises" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; padding-top: 0.5rem;">
        Annuler
      </a>
    </div>

  </form>
</section>