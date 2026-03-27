<?php
/**
 * VUE : Détail d'un pilote
 * La variable $pilote est fournie par PiloteController->show($id)
 */
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=pilotes" style="color: var(--accent-blue);">Pilotes</a> &gt;
    <span style="color: var(--text-muted);">Détail pilote</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 2rem; align-items: start;">

  <aside>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; background: var(--accent-blue); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: var(--bg-dark);">
          <?= strtoupper(substr($pilote['prenom'], 0, 1) . substr($pilote['nom'], 0, 1)) ?>
        </div>
        <h2 style="font-size: 1.2rem;"><?= htmlspecialchars($pilote['prenom'] . ' ' . $pilote['nom']) ?></h2>
        <p style="font-size: 0.8rem; color: var(--accent-purple);">Pilote de Promotion</p>
      </div>

      <ul style="list-style: none; font-size: 0.9rem; line-height: 2;">
        <li><strong style="color: var(--text-muted);">Email :</strong><br> <?= htmlspecialchars($pilote['email']) ?></li>
        <li><strong style="color: var(--text-muted);">Centre :</strong><br> <?= htmlspecialchars($pilote['centre_nom'] ?? 'Non assigné') ?></li>
        <li><strong style="color: var(--text-muted);">Compte créé le :</strong><br> <?= !empty($pilote['created_at']) ? date('d/m/Y à H:i', strtotime($pilote['created_at'])) : 'Non renseignée' ?></li>
      </ul>

      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
      <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
        <a href="index.php?page=pilote-edit&id=<?= (int) $pilote['id'] ?>" class="btn-cta" style="display: block; text-align: center; margin-bottom: 0.7rem; font-size: 0.85rem;">
            Modifier le compte
        </a>
        <form action="index.php?page=pilote-delete" method="post" onsubmit="return confirm('Supprimer ce pilote ?');">
            <input type="hidden" name="id" value="<?= (int) $pilote['id'] ?>">
            <button type="submit" style="width: 100%; background: transparent; border: 1px solid #ff4444; color: #ff4444; font-size: 0.85rem; cursor: pointer; padding: 0.5rem;">
                Supprimer le pilote
            </button>
        </form>
      </div>
      <?php endif; ?>
    </section>
  </aside>

  <div>
    <section>
      <h2 style="margin-bottom: 1.5rem;">Candidatures des étudiants rattachés</h2>

      <div class="container-espaces" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
          <p style="color: var(--text-muted);">Cette fonctionnalité (liste des étudiants du pilote) sera bientôt disponible.</p>

          <article class="card" style="position: relative; border: 1px solid var(--border); padding: 1rem; border-radius: 8px;">
            <h3 style="font-size: 1rem; color: var(--accent-blue);">Exemple Étudiant</h3>
            <p style="font-size: 0.85rem;">Dernière offre consultée : Développeur Web</p>
          </article>
      </div>
    </section>
  </div>
</div>