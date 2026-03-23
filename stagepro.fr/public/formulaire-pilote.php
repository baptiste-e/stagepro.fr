<?php 
  $titre_page = "Gestion Pilote | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="pilote.php" style="color: var(--accent-blue);">Pilotes</a> &gt;
    <span style="color: var(--text-muted);">Création / Modification</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Gérer un compte pilote</h1>
  <p style="color: var(--text-muted);">Formulaire de création ou de modification d'un tuteur de promotion.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-pilote.php" method="post" style="max-width: 800px; background: var(--surface); padding: 2.5rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        
        <div class="form-group">
          <label for="nom">Nom du pilote</label>
          <input type="text" id="nom" name="nom" placeholder="Ex: MARTIN" required>
        </div>

        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" placeholder="Ex: Sophie" required>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="email">Adresse email professionnelle</label>
          <input type="email" id="email" name="email" placeholder="smartin@cesi.fr" required>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="centre">Centre de formation</label>
          <select id="centre" name="centre" required style="width: 100%; background: #000; color: var(--text-main); border: 1px solid var(--border); padding: 0.7rem; border-radius: 4px;">
            <option value="">-- Sélectionner un centre --</option>
            <option value="lyon">CESI Lyon</option>
            <option value="paris">CESI Paris</option>
            <option value="nantes">CESI Nantes</option>
            <option value="toulouse">CESI Toulouse</option>
          </select>
        </div>

    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit">Enregistrer le compte</button>
      <a href="pilote.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
        Annuler
      </a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>