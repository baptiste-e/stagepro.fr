<?php 
  $titre_page = "Gestion Étudiant | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="etudiant.php" style="color: var(--accent-blue);">Étudiants</a> &gt;
    <span style="color: var(--text-muted);">Création / Modification</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Gérer un compte étudiant</h1>
  <p style="color: var(--text-muted);">Administration des profils et suivi de l'état d'avancement.</p>
</section>

<section style="margin-top: 2rem;">
  <form action="traitement-etudiant.php" method="post" style="max-width: 800px; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        
        <div class="form-group">
          <label for="nom">Nom de l'élève</label>
          <input type="text" id="nom" name="nom" placeholder="Ex: DUPONT" required>
        </div>

        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" placeholder="Ex: Jean" required>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="email">Adresse email CESI (ou personnelle)</label>
          <input type="email" id="email" name="email" placeholder="jean.dupont@viacesi.fr" required>
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="etat">État de la recherche de stage</label>
          <select id="etat" name="etat" required style="width: 100%; background: #ffffff; color: var(--text-main); border: 1px solid var(--border); padding: 0.7rem; border-radius: 4px;">
            <option value="">-- Sélectionner un statut --</option>
            <option value="non_commence">⚪ Non commencée</option>
            <option value="en_cours">🔵 En cours (recherche active)</option>
            <option value="entretiens">🟡 Entretiens planifiés</option>
            <option value="stage_trouve">🟢 Stage trouvé / Conventionné</option>
          </select>
        </div>

    </div>

    <div style="margin-top: 2.5rem; display: flex; align-items: center; gap: 2rem;">
      <button type="submit">Enregistrer le profil</button>
      <a href="etudiant.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
        Annuler
      </a>
    </div>

  </form>
</section>

<?php include 'includes/footer.php'; ?>