<?php 
  $titre_page = "Profil Pilote | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="pilote.php" style="color: var(--accent-blue);">Pilotes</a> &gt;
    <span style="color: var(--text-muted);">Détail pilote</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 2rem; align-items: start;">
  
  <aside>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; background: var(--accent-blue); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: var(--bg-dark);">
          SM
        </div>
        <h2 style="font-size: 1.2rem;">Sophie Martin</h2>
        <p style="font-size: 0.8rem; color: var(--accent-purple);">Pilote de Promotion</p>
      </div>

      <ul style="list-style: none; font-size: 0.9rem; line-height: 2;">
        <li><strong style="color: var(--text-muted);">Email :</strong><br> smartin@cesi.fr</li>
        <li><strong style="color: var(--text-muted);">Centre :</strong><br> CESI Lyon</li>
      </ul>

      <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
        <a href="formulaire-pilote.php?id=5" class="btn-cta" style="display: block; text-align: center; margin-bottom: 0.7rem; font-size: 0.85rem;">
            Modifier le compte
        </a>
        <button type="button" style="width: 100%; background: transparent; border: 1px solid #ff4444; color: #ff4444; font-size: 0.85rem; cursor: pointer;">
            Supprimer le pilote
        </button>
      </div>
    </section>
  </aside>

  <main-content>
    <section>
      <h2 style="margin-bottom: 1.5rem;">Candidatures des étudiants rattachés</h2>
      
      <div class="container-espaces" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
          <article class="card">
            <h3 style="font-size: 1rem; color: var(--accent-blue);">Jean Dupont</h3>
            <p style="font-size: 0.85rem;">Offre : <strong>Développeur PHP</strong></p>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Statut : En attente</p>
            <a href="detail-candidature.php?id=123" class="lien-etendu"></a>
          </article>

          <article class="card">
            <h3 style="font-size: 1rem; color: var(--accent-blue);">Alice Martin</h3>
            <p style="font-size: 0.85rem;">Offre : <strong>UI Designer</strong></p>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Statut : Entretien</p>
            <a href="detail-candidature.php?id=124" class="lien-etendu"></a>
          </article>
      </div>

      <nav aria-label="Pagination" style="margin-top: 2rem; display: flex; gap: 0.5rem; justify-content: center;">
        <button type="button" disabled style="opacity: 0.5;">&lt;</button>
        <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
        <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">2</button>
        <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
      </nav>
    </section>
  </main-content>

</div>

<?php include 'includes/footer.php'; ?>