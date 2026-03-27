<?php
/**
 * VUE : Liste des offres
 */
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Catalogue des offres</h1>
      <p style="color: var(--text-muted);">Explorez les opportunités de stage et propulsez votre carrière.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="index.php?page=offres-stats" class="btn-cta">Consulter les statistiques</a>

        <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'], ['admin', 'pilote'])): ?>
          <a href="index.php?page=offre-create" class="btn-cta">+ Publier une offre</a>
        <?php endif; ?>
    </div>
  </div>
</section>

<section style="margin-top: 2rem; background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
  <h2 style="margin-bottom: 1.5rem; font-size: 1.2rem; color: var(--accent-blue);">Filtrer les résultats</h2>

  <form action="index.php" method="get">
    <input type="hidden" name="page" value="offres">

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem;">
      <div class="form-group">
        <label for="titre">Titre / Mot-clé</label>
        <input type="search" id="titre" name="titre" placeholder="Développeur..." value="<?= htmlspecialchars($_GET['titre'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="entreprise">Entreprise</label>
        <input type="text" id="entreprise" name="entreprise" placeholder="Ex: TechCorp" value="<?= htmlspecialchars($_GET['entreprise'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="competences">Compétences</label>
        <input type="text" id="competences" name="competences" placeholder="SQL, React..." value="<?= htmlspecialchars($_GET['competences'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="remuneration">Gratification min. (€)</label>
        <input type="number" id="remuneration" name="remuneration" min="0" placeholder="Ex: 600" value="<?= htmlspecialchars($_GET['remuneration'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="date_offre">Date exacte</label>
        <input type="date" id="date_offre" name="date_offre" value="<?= htmlspecialchars($_GET['date_offre'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="date_debut">Date min.</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($_GET['date_debut'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label for="date_fin">Date max.</label>
        <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($_GET['date_fin'] ?? '') ?>">
      </div>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
      <button type="submit">Rechercher</button>
      <a href="index.php?page=offres" style="text-decoration: none; padding: 0.6rem 1rem; border: 1px solid var(--border); color: var(--text-muted); border-radius: 4px; font-size: 0.9rem;">Réinitialiser</a>
    </div>
  </form>
</section>

<section style="margin-top: 3rem; margin-bottom: 5rem;">
  <h2>Offres de stage disponibles</h2>

  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-top: 1.5rem;">
    <?php if (!empty($offres)): ?>
      <?php foreach ($offres as $offre): ?>
        <article style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px; display: flex; flex-direction: column; gap: 1rem; transition: transform 0.2s; position: relative;">

            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                <h3 style="font-size: 1.1rem; color: var(--accent-purple); margin: 0;"><?= htmlspecialchars($offre['titre']) ?></h3>
                <?php if (!empty($offre['created_at']) && strtotime($offre['created_at']) > strtotime('-3 days')): ?>
                    <span style="font-size: 0.7rem; background: #4ade8020; color: #4ade80; padding: 2px 8px; border-radius: 4px; font-weight: bold;">Récent</span>
                <?php endif; ?>
            </div>

            <p style="font-weight: 600; font-size: 0.9rem; margin: 0;">
              🏢 <?= htmlspecialchars($offre['entreprise_nom'] ?? 'Entreprise inconnue') ?>
            </p>

            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
              <strong>Date de l'offre :</strong>
              <?= !empty($offre['date_offre']) ? date('d/m/Y', strtotime($offre['date_offre'])) : 'Non renseignée' ?>
            </p>

            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
              <strong>Ajoutée sur la plateforme :</strong>
              <?= !empty($offre['created_at']) ? date('d/m/Y à H:i', strtotime($offre['created_at'])) : 'Non renseignée' ?>
            </p>

            <p style="font-size: 0.85rem; color: var(--text-muted); flex-grow: 1; line-height: 1.5;">
                <?= substr(htmlspecialchars($offre['description'] ?? ''), 0, 120) ?>...
            </p>

            <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.85rem; color: var(--accent-blue); font-weight: bold;">
                    <?= !empty($offre['remuneration']) ? number_format((float)$offre['remuneration'], 2, ',', ' ') . ' €' : 'N/C' ?>
                </span>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <a href="index.php?page=offre-detail&id=<?= (int)$offre['id'] ?>" style="color: var(--accent-purple); font-size: 0.9rem; text-decoration: none; font-weight: 500;">Détails →</a>

                    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'], ['admin', 'pilote'])): ?>
                        <div style="display: flex; gap: 8px; margin-left: 5px; border-left: 1px solid var(--border); padding-left: 10px;">
                            <a href="index.php?page=offre-edit&id=<?= (int)$offre['id'] ?>" title="Modifier" style="text-decoration: none; font-size: 1rem;">✏️</a>

                            <a href="index.php?page=offre-delete&id=<?= (int)$offre['id'] ?>"
                               style="text-decoration: none; font-size: 1rem;"
                               onclick="return confirm('Supprimer définitivement cette offre ?')"
                               title="Supprimer">
                               🗑️
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="grid-column: 1 / -1; text-align: center; padding: 5rem; color: var(--text-muted); background: var(--surface); border-radius: 8px; border: 1px dashed var(--border);">
        Aucune offre ne correspond à vos critères.
      </p>
    <?php endif; ?>
  </div>
</section>