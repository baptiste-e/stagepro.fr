<?php
$titre_page = "Annuaire des pilotes | StagePro";
include 'includes/header.php';
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Annuaire des pilotes</h1>
      <p style="color: var(--text-muted);">Gérez les comptes des tuteurs et responsables de promotion.</p>
    </div>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
      <a href="formulaire-pilote.php" class="btn-cta" style="font-size: 0.85rem;">+ Créer un pilote</a>
    <?php endif; ?>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem;">Rechercher un pilote</h2>

  <form action="pilote.php" method="get">
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
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
      <h3>Sophie Martin</h3>
      <p><strong>Centre :</strong> CESI Lyon</p>
      <p>smartin@cesi.fr</p>
      <hr>
      <p>24 étudiants suivis</p>
    </article>

    <article class="card">
      <h3>Robert Bernard</h3>
      <p><strong>Centre :</strong> CESI Paris</p>
      <p>rbernard@cesi.fr</p>
      <hr>
      <p>18 étudiants suivis</p>
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