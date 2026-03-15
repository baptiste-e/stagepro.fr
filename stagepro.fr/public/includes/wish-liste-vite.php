<?php 
  $titre_page = "Ma Wish-list | StagePro";
  include 'includes/header.php'; 
  
  // Simuler pour le moment si la liste est vide ou non
  $wishlist_est_vide = true; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <span style="color: var(--text-muted);">Ma wish-list</span>
  </p>
</nav>

<section style="min-height: 50vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
    
    <?php if ($wishlist_est_vide): ?>
        <div style="background: var(--surface); padding: 3rem; border-radius: 12px; border: 1px dashed var(--border); max-width: 500px;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">⭐</div>
            <h1 style="margin-bottom: 1rem;">Votre wish-list est vide</h1>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">
                Vous n'avez pas encore enregistré d'offres de stage. Parcourez le catalogue pour trouver les opportunités qui vous correspondent !
            </p>
            <a href="offres.php" class="btn-cta">Explorer les offres de stage</a>
        </div>
    <?php else: ?>
        <div style="width: 100%; text-align: left;">
            <h1 style="margin-bottom: 2rem;">Mes offres sauvegardées</h1>
            <div class="container-espaces">
                </div>
        </div>
    <?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>