<?php 
  $titre_page = "Annuaire Étudiants | StagePro";
  include 'includes/header.php'; 
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des étudiants</h1>
      <p style="color: var(--text-muted);">Gérez les comptes et suivez l'avancement des recherches.</p>
    </div>
    <a href="formulaire-etudiant.php" class="btn-cta" style="font-size: 0.85rem;">+ Créer un étudiant</a>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem; color: var(--accent-blue);">Filtres de recherche</h2>
  
  <form action="etudiant.php" method="get">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
      
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" placeholder="DUPONT">
      </div>

      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Jean">
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="viacesi.fr">
      </div>

      <div class="form-group">
        <label for="etat">État de recherche</label>
        <select id="etat" name="etat">
          <option value="">Tous les statuts</option>
          <option value="non_commence">⚪ Non commencée</option>
          <option value="en_cours">🔵 En cours</option>
          <option value="entretiens">🟡 Entretiens</option>
          <option value="stage_trouve">🟢 Stage trouvé</option>
        </select>
      </div>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
      <button type="submit">Rechercher</button>
      <button type="reset" style="background: transparent; border: 1px solid var(--border); color: var(--text-muted);">Réinitialiser</button>
    </div>
  </form>
</section>

<section style="margin-top: 3rem;">
  <h2>Liste des étudiants</h2>
  
  <div class="container-espaces" style="margin-top: 1.5rem;">
      <article class="card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
            <div style="width: 40px; height: 40px; background: var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--bg-dark);">JD</div>
            <h3 style="font-size: 1rem; margin: 0;">Jean Dupont</h3>
        </div>
        <p style="font-size: 0.85rem;"><strong>Statut :</strong> <span style="color: var(--accent-blue);">En cours</span></p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">jean.dupont@viacesi.fr</p>
        <a href="detail-etudiant.php?id=1" class="lien-etendu">Voir le profil</a>
      </article>

      <article class="card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
            <div style="width: 40px; height: 40px; background: #4ade80; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--bg-dark);">AM</div>
            <h3 style="font-size: 1rem; margin: 0;">Alice Martin</h3>
        </div>
        <p style="font-size: 0.85rem;"><strong>Statut :</strong> <span style="color: #4ade80;">Stage trouvé</span></p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">alice.martin@viacesi.fr</p>
        <a href="detail-etudiant.php?id=2" class="lien-etendu">Voir le profil</a>
      </article>
  </div>

  <nav aria-label="Pagination" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>