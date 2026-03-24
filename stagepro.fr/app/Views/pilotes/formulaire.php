<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=pilotes" style="color: var(--accent-blue);">Pilotes</a> &gt;
    <span style="color: var(--text-muted);">Création</span>
  </p>
</nav>

<section>
  <h1>Créer un pilote</h1>
  <p style="color: var(--text-muted);">Ajoutez un nouveau compte pilote pour la gestion des promotions.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=pilote-save" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" placeholder="Ex: Martin" required>
    </div>

    <div class="form-group">
      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" placeholder="Ex: Jean" required>
    </div>

    <div class="form-group">
      <label for="email">Email professionnel</label>
      <input type="email" id="email" name="email" placeholder="Ex: jmartin@cesi.fr" required>
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem; align-items: center;">
      <button type="submit">Enregistrer le pilote</button>
      <a href="index.php?page=pilotes" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Annuler</a>
    </div>

  </form>
</section>