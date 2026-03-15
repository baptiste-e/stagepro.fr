<?php 
  $titre_page = "Tableau de Bord Administrateur | StagePro";
  include 'includes/header.php'; 
?>

<section>
  <h1 style="margin-bottom: 0.5rem;">Console d'administration</h1>
  <p style="color: var(--text-muted);">Gestion globale des utilisateurs, des entreprises et monitoring du système.</p>
</section>

<div class="container-espaces" style="margin-top: 2rem; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="card" style="border-left: 4px solid var(--accent-blue);">
        <h3 style="font-size: 0.8rem; color: var(--text-muted);">ÉTUDIANTS</h3>
        <p style="font-size: 1.8rem; font-weight: bold;">1,240</p>
    </div>
    <div class="card" style="border-left: 4px solid var(--accent-purple);">
        <h3 style="font-size: 0.8rem; color: var(--text-muted);">PILOTES</h3>
        <p style="font-size: 1.8rem; font-weight: bold;">45</p>
    </div>
    <div class="card" style="border-left: 4px solid #fbbf24;">
        <h3 style="font-size: 0.8rem; color: var(--text-muted);">ENTREPRISES</h3>
        <p style="font-size: 1.8rem; font-weight: bold;">312</p>
    </div>
    <div class="card" style="border-left: 4px solid #4ade80;">
        <h3 style="font-size: 0.8rem; color: var(--text-muted);">OFFRES ACTIVES</h3>
        <p style="font-size: 1.8rem; font-weight: bold;">89</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-top: 3rem;">
    
    <section>
        <h2 style="margin-bottom: 1.5rem;">Actions de gestion</h2>
        <div class="container-espaces" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
            <article class="card">
                <h3>Utilisateurs</h3>
                <p style="font-size: 0.8rem;">Créer, modifier ou bannir des comptes (Étudiants/Pilotes).</p>
                <div style="margin-top: 1rem; display: flex; gap: 10px;">
                    <a href="etudiant.php" class="btn-cta" style="font-size: 0.7rem; padding: 5px 10px;">Étudiants</a>
                    <a href="pilote.php" class="btn-cta" style="font-size: 0.7rem; padding: 5px 10px; background: var(--accent-purple);">Pilotes</a>
                </div>
            </article>

            <article class="card">
                <h3>Entreprises</h3>
                <p style="font-size: 0.8rem;">Valider les nouveaux partenaires ou éditer les fiches.</p>
                <div style="margin-top: 1rem;">
                    <a href="entreprises.php" class="btn-cta" style="font-size: 0.7rem; padding: 5px 10px;">Gérer le catalogue</a>
                </div>
            </article>

            <article class="card">
                <h3>Offres de stage</h3>
                <p style="font-size: 0.8rem;">Modération des offres et suivi des statistiques.</p>
                <div style="margin-top: 1rem;">
                    <a href="offres.php" class="btn-cta" style="font-size: 0.7rem; padding: 5px 10px;">Modérer</a>
                </div>
            </article>

            <article class="card">
                <h3>Maintenance</h3>
                <p style="font-size: 0.8rem;">Sauvegarde de la base de données et logs système.</p>
                <div style="margin-top: 1rem;">
                    <button style="font-size: 0.7rem; padding: 5px 10px; background: #ff4444; color: white;">Backup DB</button>
                </div>
            </article>
        </div>
    </section>

    <aside style="background: var(--surface); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
        <h2 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--accent-blue);">Dernières alertes</h2>
        <ul style="list-style: none; font-size: 0.85rem; line-height: 1.6;">
            <li style="margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                <span style="color: #f87171;">●</span> <strong>Nouvelle Entreprise</strong> à valider : <em>CyberSoft</em>
                <br><small style="color: var(--text-muted);">Il y a 12 min</small>
            </li>
            <li style="margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                <span style="color: #fbbf24;">●</span> Inscription Pilote en attente : <strong>M. Legrand</strong>
                <br><small style="color: var(--text-muted);">Il y a 2h</small>
            </li>
            <li>
                <span style="color: #4ade80;">●</span> Backup auto effectué avec succès.
                <br><small style="color: var(--text-muted);">Ce matin à 04:00</small>
            </li>
        </ul>
    </aside>
</div>

<?php include 'includes/footer.php'; ?>