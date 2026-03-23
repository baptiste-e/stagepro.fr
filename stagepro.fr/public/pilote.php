<?php 
  $titre_page = "Annuaire Pilotes | StagePro";
  include 'includes/header.php'; 
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des pilotes</h1>
      <p style="color: var(--text-muted);">Gérez les comptes des tuteurs et responsables de promotion.</p>
    </div>
    <a href="formulaire-pilote.php" class="btn-cta" style="font-size: 0.85rem;">+ Créer un pilote</a>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem; color: var(--accent-blue);">Rechercher un pilote</h2>
  
  <form action="pilote.php" method="get">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
      
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" placeholder="Ex: MARTIN">
      </div>

      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Ex: Sophie">
      </div>

    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
      <button type="submit">Lancer la recherche</button>
      <button type="reset" style="background: transparent; border: 1px solid var(--border); color: var(--text-muted);">Réinitialiser</button>
    </div>
  </form>
</section>

<section style="margin-top: 3rem;">
  <h2>Pilotes enregistrés</h2>
  
  <div class="container-espaces" style="margin-top: 1.5rem;">
      
      <article class="card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
            <div style="width: 40px; height: 40px; background: var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--bg-dark);">SM</div>
            <h3 style="font-size: 1rem; margin: 0;">Sophie Martin</h3>
        </div>
        <p style="font-size: 0.85rem;"><strong>Centre :</strong> CESI Lyon</p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">smartin@cesi.fr</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <p style="font-size: 0.75rem; color: var(--accent-purple);">24 étudiants suivis</p>
        </div>
        <a href="detail-pilote.php?id=1" class="lien-etendu"></a>
      </article>

      <article class="card">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
            <div style="width: 40px; height: 40px; background: var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--bg-dark);">RB</div>
            <h3 style="font-size: 1rem; margin: 0;">Robert Bernard</h3>
        </div>
        <p style="font-size: 0.85rem;"><strong>Centre :</strong> CESI Paris</p>
        <p style="font-size: 0.8rem; color: var(--text-muted);">rbernard@cesi.fr</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <p style="font-size: 0.75rem; color: var(--accent-purple);">18 étudiants suivis</p>
        </div>
        <a href="detail-pilote.php?id=2" class="lien-etendu"></a>
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