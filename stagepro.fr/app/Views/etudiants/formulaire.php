<section>
  <nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
    <p>
      <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
      <a href="index.php?page=etudiants" style="color: var(--accent-blue);">Étudiants</a> &gt;
      <span style="color: var(--text-muted);">Création</span>
    </p>
  </nav>

  <h1>Créer un étudiant</h1>
  <p style="color: var(--text-muted);">Ajoutez un nouveau compte étudiant.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="index.php?page=etudiant-save" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div style="margin-top: 2rem;">
      <button type="submit">Enregistrer l'étudiant</button>
      <a href="index.php?page=etudiants" style="margin-left: 1rem; color: var(--text-muted); text-decoration: none;">Annuler</a>
    </div>

  </form>
</section>