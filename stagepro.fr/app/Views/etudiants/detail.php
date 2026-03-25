<?php
/**
 * VUE : Détail d'un étudiant / pilote
 */
$u = $etudiant ?? $pilote ?? $utilisateur; 

// Sécurité : Si l'utilisateur n'existe pas, on redirige
if (!$u) {
    echo "<p>Erreur : Utilisateur introuvable.</p>";
    return;
}
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
        <h2 style="font-size: 1.2rem;"><?= htmlspecialchars(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')) ?></h2>
        <p style="font-size: 0.8rem; color: var(--accent-purple); font-weight: bold;">
            <?= htmlspecialchars($u['role_nom'] ?? 'Utilisateur') ?>
        </p>
      </div>

      <ul style="list-style: none; font-size: 0.9rem; line-height: 2; padding: 0;">
        <li><strong style="color: var(--text-muted);">Email :</strong><br> 
            <?= htmlspecialchars($u['email'] ?? 'Non renseigné') ?>
        </li>
        <li><strong style="color: var(--text-muted);">Centre :</strong><br> 
            <?= htmlspecialchars($u['centre_nom'] ?? 'Non assigné') ?>
        </li>
      </ul>

      <?php 
        // RÉPARATION DE LA CONDITION DE RÔLE
        // On vérifie role_nom OU role (au cas où) et on passe tout en minuscule pour éviter les surprises
        $rawRole = $_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '';
        $userRole = strtolower(trim($rawRole)); 

        if ($userRole === 'admin' || $userRole === 'pilote'): 
      ?>
      <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
        
        <a href="index.php?page=etudiant-edit&id=<?= (int)$u['id'] ?>" class="btn-cta" style="display: block; text-align: center; margin-bottom: 0.7rem; font-size: 0.85rem; text-decoration: none; background: var(--accent-blue); color: white; padding: 0.6rem; border-radius: 4px;">
            Modifier le compte
        </a>

        <form action="index.php?page=etudiant-delete" method="post" onsubmit="return confirm('Attention : Supprimer cet utilisateur supprimera aussi ses candidatures. Confirmer ?');">
            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
            <button type="submit" style="width: 100%; background: transparent; border: 1px solid #ff4444; color: #ff4444; font-size: 0.85rem; cursor: pointer; padding: 0.5rem; border-radius: 4px; transition: 0.3s; margin-top: 0.5rem;">
                Supprimer l'utilisateur
            </button>
        </form>

      </div>
      <?php endif; ?>
    </section>
  </aside>

  <main-content>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <h2 style="margin-bottom: 1.5rem;">Candidatures / Activité</h2>
      
      <div class="container-espaces" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
          <article class="card" style="border: 1px solid var(--border); padding: 1rem; border-radius: 8px; background: rgba(255,255,255,0.02);">
            <h3 style="font-size: 1rem; color: var(--accent-blue); margin-bottom: 0.5rem;">Candidatures en cours</h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">Aucune candidature active pour le moment.</p>
          </article>
      </div>
    </section>
  </main-content>

</div>