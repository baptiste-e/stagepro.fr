<?php 
  $titre_page = "Ma Wish-list | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Ma wish-list</span>
  </p>
</nav>

<section>
  <h1>Ma wish-list</h1>
  <p style="color: var(--text-muted);">Retrouvez les offres de stage qui ont retenu votre attention.</p>
</section>

<section style="margin-top: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Offres sauvegardées</h2>
    <span style="font-size: 0.9rem; background: var(--surface); padding: 5px 12px; border-radius: 20px; border: 1px solid var(--border);">
        3 offres enregistrées
    </span>
  </div>

  <div class="container-espaces">
      
      <article class="card">
        <h3 style="color: var(--accent-blue);">Développeur Fullstack PHP</h3>
        <p><strong>Entreprise :</strong> TechCorp</p>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">📍 Lyon (69)</p>
        
        <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
            <a href="detail-offre.php?id=101" class="btn-cta" style="font-size: 0.75rem; padding: 5px 10px;">Postuler</a>
            <form action="traitement-wishlist.php" method="post" style="display:inline;">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="id_offre" value="101">
                <button type="submit" title="Retirer de la liste" style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 5px 10px; font-size: 0.75rem;">
                    Retirer
                </button>
            </form>
        </div>
        <a href="detail-offre.php?id=101" class="lien-etendu"></a>
      </article>

      <article class="card">
        <h3 style="color: var(--accent-blue);">UX/UI Designer</h3>
        <p><strong>Entreprise :</strong> CreativeLab</p>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">📍 Nantes (44)</p>
        
        <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
            <a href="detail-offre.php?id=105" class="btn-cta" style="font-size: 0.75rem; padding: 5px 10px;">Postuler</a>
            <button type="button" style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 5px 10px; font-size: 0.75rem;">Retirer</button>
        </div>
        <a href="detail-offre.php?id=105" class="lien-etendu"></a>
      </article>

  </div>

  <nav aria-label="Pagination" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
    <button type="button" disabled style="opacity: 0.5;">&lt;</button>
    <button type="button" class="btn-cta" style="padding: 5px 12px;">1</button>
    <button type="button" style="padding: 5px 12px; background: var(--surface); border: 1px solid var(--border);">&gt;</button>
  </nav>
</section>

<?php include 'includes/footer.php'; ?>