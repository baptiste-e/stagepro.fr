<?php
/**
 * VUE : Détail d'une entreprise
 * La variable $entreprise est fournie par EntrepriseController
 */
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=entreprises" style="color: var(--accent-blue);">Entreprises</a> &gt;
    <span style="color: var(--text-muted);">Fiche Entreprise</span>
  </p>
</nav>

<article style="background: var(--surface); padding: 2.5rem; border-radius: 12px; border: 1px solid var(--border); max-width: 900px; margin: 0 auto;">
    <header style="border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                <?= htmlspecialchars($entreprise['nom']) ?>
            </h1>
            <p style="color: var(--text-muted);">Secteur d'activité : <?= htmlspecialchars($entreprise['secteur'] ?? 'Non renseigné') ?></p>
        </div>
        <div style="text-align: right;">
             <span style="background: rgba(129, 140, 248, 0.1); color: var(--accent-blue); padding: 5px 15px; border-radius: 20px; font-weight: bold;">
                ID #<?= (int)$entreprise['id'] ?>
             </span>
        </div>
    </header>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="color: var(--accent-blue); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Localisation</h3>
            <p>📍 <?= htmlspecialchars($entreprise['localite'] ?? 'N/C') ?></p>
        </div>
        <div>
            <h3 style="color: var(--accent-blue); font-size: 0.9rem; text-transform: uppercase; margin-bottom: 0.5rem;">Confiance stagiaires</h3>
            <p>⭐ <?= htmlspecialchars($entreprise['confiance'] ?? 'N/C') ?> / 5</p>
        </div>
    </div>

    <div style="line-height: 1.8;">
        <h3 style="color: var(--text-main); margin-bottom: 1rem;">À propos de l'entreprise</h3>
        <p style="color: var(--text-muted);">
            <?= nl2br(htmlspecialchars($entreprise['description'] ?? 'Aucune description disponible pour cette entreprise.')) ?>
        </p>
    </div>

    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role_nom'] ?? '', ['admin', 'pilote'])): ?>
    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px dashed var(--border); display: flex; gap: 1rem;">
        <a href="index.php?page=entreprise-edit&id=<?= $entreprise['id'] ?>" class="btn-cta">Modifier la fiche</a>
    </div>
    <?php endif; ?>
</article>