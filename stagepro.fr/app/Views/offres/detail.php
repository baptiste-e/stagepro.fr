<?php
/**
 * VUE : Détail d'une offre
 * La variable $offre est fournie par OffreController->show($id)
 */
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=offres" style="color: var(--accent-blue);">Offres</a> &gt;
    <span style="color: var(--text-muted);">Détail de l’offre</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
  
  <div>
    <section>
      <h1 style="font-size: 2.2rem; margin-bottom: 0.5rem;">
        <?= htmlspecialchars($offre['titre']) ?>
      </h1>

      <p style="font-size: 1.2rem; color: var(--accent-blue); margin-bottom: 2rem;">
        <?= htmlspecialchars($offre['entreprise_nom']) ?>
      </p>
      
      <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
          Description du poste
        </h2>
        <p style="line-height: 1.8; color: var(--text-main);">
          <?= nl2br(htmlspecialchars($offre['description'] ?? 'Aucune description disponible.')) ?>
        </p>
      </div>

      <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
          Compétences requises
        </h2>
        <p style="color: var(--text-muted);">
          Compétences non renseignées pour le moment.
        </p>
      </div>
    </section>

    <section id="postuler" style="margin-top: 4rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--accent-blue);">
      <h2 style="margin-bottom: 1.5rem;">Postuler à cette offre</h2>

      <form action="index.php?page=postuler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_offre" value="<?= (int) $offre['id'] ?>">
        
        <div class="form-group">
          <label for="cv">Votre CV (PDF)</label>
          <input type="file" id="cv" name="cv" accept=".pdf" required>
        </div>

        <div class="form-group">
          <label for="lm">Lettre de motivation</label>
          <textarea id="lm" name="lm" rows="6" placeholder="Exprimez votre intérêt pour ce poste..." required></textarea>
        </div>

        <button type="submit" style="width: 100%;">Envoyer ma candidature</button>
      </form>
    </section>
  </div>

  <aside>
    <div style="background: var(--surface); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 2rem;">
      <h3 style="font-size: 0.9rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 1.5rem;">
        Détails financiers
      </h3>

      <p style="font-size: 1.8rem; font-weight: bold; color: var(--accent-blue);">
        <?= number_format((float) ($offre['remuneration'] ?? 0), 2, ',', ' ') ?> €
        <span style="font-size: 0.9rem; color: var(--text-muted);">/ mois</span>
      </p>

      <p style="margin-top: 1rem; font-size: 0.9rem;">
        <strong>Date de l'offre :</strong> <?= htmlspecialchars($offre['date_offre'] ?? '-') ?>
      </p>
      
      <form action="index.php?page=wishlist-add" method="post">
          <input type="hidden" name="id_offre" value="<?= (int) $offre['id'] ?>">
          <button type="submit" style="width: 100%; margin-top: 1.5rem; background: transparent; border: 1px solid var(--accent-purple); color: var(--accent-purple); cursor: pointer;">
            ⭐ Ajouter à la wish-list
          </button>
      </form>
    </div>

    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'pilote'])): ?>
    <div style="border: 1px dashed var(--border); padding: 1.5rem; border-radius: 8px;">
      <h3 style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">
        ADMINISTRATION
      </h3>

      <a href="index.php?page=offre-edit&id=<?= (int) $offre['id'] ?>" class="btn-cta" style="display: block; text-align: center; font-size: 0.85rem; margin-bottom: 0.5rem;">
        Modifier l'offre
      </a>

      <form action="index.php?page=offre-delete" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette offre ?');">
        <input type="hidden" name="id" value="<?= (int) $offre['id'] ?>">
        <button type="submit" style="width: 100%; background: #ff4444; color: white; font-size: 0.85rem; cursor: pointer;">
          Supprimer
        </button>
      </form>
    </div>
    <?php endif; ?>
  </aside>

</div>