<?php
/**
 * VUE : Détail d'un étudiant
 * La variable $etudiant est fournie par EtudiantController->show($id)
 */
$u = $etudiant ?? $utilisateur;

// Sécurité : Si l'utilisateur n'existe pas dans la base
if (!$u) {
    echo "<div style='padding:2rem; background:white; color:red;'>Erreur : Étudiant introuvable.</div>";
    return;
}

/**
 * RÉCUPÉRATION DU RÔLE DE LA SESSION
 * On normalise la vérification pour que "Admin", "admin" ou "ADMIN" fonctionnent tous.
 */
$sessionRoleRaw = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
$sessionRole = strtolower(trim($sessionRoleRaw));
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php?page=home" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="index.php?page=etudiants" style="color: var(--accent-blue);">Étudiants</a> &gt;
    <span style="color: var(--text-muted);">Détail profil</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 2rem; align-items: start;">

  <aside>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; background: var(--accent-blue); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: var(--bg-dark);">
          <?= strtoupper(substr($u['prenom'] ?? 'U', 0, 1) . substr($u['nom'] ?? 'U', 0, 1)) ?>
        </div>
        <h2 style="font-size: 1.2rem; color: #333;"><?= htmlspecialchars(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')) ?></h2>
        <p style="font-size: 0.8rem; color: var(--accent-purple); font-weight: bold;">Étudiant</p>
      </div>

      <ul style="list-style: none; font-size: 0.9rem; line-height: 2; padding: 0;">
        <li>
            <strong style="color: var(--text-muted);">Email :</strong><br>
            <?= htmlspecialchars($u['email'] ?? 'Non renseigné') ?>
        </li>
        <li>
            <strong style="color: var(--text-muted);">Centre :</strong><br>
            <?= htmlspecialchars($u['centre_nom'] ?? 'Non assigné') ?>
        </li>
        <li>
            <strong style="color: var(--text-muted);">Compte créé le :</strong><br>
            <?= !empty($u['created_at']) ? date('d/m/Y à H:i', strtotime($u['created_at'])) : 'Non renseignée' ?>
        </li>
      </ul>

      <?php if ($sessionRole === 'admin' || $sessionRole === 'pilote'): ?>
      <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">

        <a href="index.php?page=etudiant-edit&id=<?= (int)$u['id'] ?>"
           style="display: block; text-align: center; margin-bottom: 0.7rem; font-size: 0.85rem; text-decoration: none; background: #2563eb; color: white; padding: 0.6rem; border-radius: 4px; font-weight: bold;">
            Modifier le compte
        </a>

        <form action="index.php?page=etudiant-delete" method="post" onsubmit="return confirm('Confirmer la suppression de cet étudiant ?');">
            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
            <button type="submit" style="width: 100%; background: white; border: 1px solid #ff4444; color: #ff4444; font-size: 0.85rem; cursor: pointer; padding: 0.5rem; border-radius: 4px; transition: 0.3s;">
                Supprimer l'étudiant
            </button>
        </form>

      </div>
      <?php endif; ?>
    </section>
  </aside>

  <main-content>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <h2 style="margin-bottom: 1.5rem; color: #333;">Candidatures / Activité</h2>

      <div class="container-espaces" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
          <article class="card" style="border: 1px solid var(--border); padding: 1rem; border-radius: 8px; background: rgba(0,0,0,0.02);">
            <h3 style="font-size: 1rem; color: var(--accent-blue);">Activité</h3>
            <p style="font-size: 0.9rem; color: var(--text-muted);">
              Cette section pourra afficher l'historique détaillé des candidatures de l'étudiant.
            </p>
          </article>
      </div>
    </section>
  </main-content>
</div>