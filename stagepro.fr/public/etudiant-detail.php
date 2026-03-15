<?php 
  $titre_page = "Profil Étudiant | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="etudiant.php" style="color: var(--accent-blue);">Étudiants</a> &gt;
    <span style="color: var(--text-muted);">Détail étudiant</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 2rem; align-items: start;">
  
  <aside>
    <section style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
      <div style="text-align: center; margin-bottom: 1.5rem;">
        <div style="width: 80px; height: 80px; background: var(--accent-purple); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: white;">
          JD
        </div>
        <h2 style="font-size: 1.2rem;">Jean Dupont</h2>
        <p style="font-size: 0.8rem; color: var(--accent-blue);">Promotion A2 - 2026</p>
      </div>

      <ul style="list-style: none; font-size: 0.9rem; line-height: 2;">
        <li><strong style="color: var(--text-muted);">Email :</strong><br> jean.dupont@viacesi.fr</li>
        <li style="margin-top: 1rem;">
            <strong style="color: var(--text-muted);">Statut :</strong><br> 
            <span style="padding: 2px 8px; background: rgba(56, 189, 248, 0.2); color: var(--accent-blue); border-radius: 4px; font-size: 0.75rem;">
                🔵 Recherche en cours
            </span>
        </li>
      </ul>

      <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
        <a href="formulaire-etudiant.php?id=42" class="btn-cta" style="display: block; text-align: center; margin-bottom: 0.7rem; font-size: 0.85rem;">
            Modifier le profil
        </a>
        <button type="button" style="width: 100%; background: transparent; border: 1px solid #ff4444; color: #ff4444; font-size: 0.85rem; cursor: pointer;">
            Supprimer l'étudiant
        </button>
      </div>
    </section>
  </aside>

  <main-content>
    <section>
      <h2 style="margin-bottom: 1.5rem;">Candidatures envoyées</h2>
      
      <div class="container-espaces" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
          <article class="card">
            <h3 style="font-size: 1rem;">Développeur Web</h3>
            <p><strong>Entreprise :</strong> TechCorp</p>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Postulé le : 10/03/2026</p>
            <div style="margin-top: 1rem; display: flex; gap: 10px;">
                <span style="font-size: 0.7rem; background: var(--border); padding: 3px 7px; border-radius: 3px;">PDF</span>
                <span style="font-size: 0.7rem; background: var(--border); padding: 3px 7px; border-radius: 3px;">LM</span>
            </div>
            <a href="detail-candidature.php?id=123" class="lien-etendu">Voir détails</a>
          </article>

          <article class="card">
            <h3 style="font-size: 1rem;">Stage CyberSécurité</h3>
            <p><strong>Entreprise :</strong> SecureNet</p>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Postulé le : 02/03/2026</p>
            <a href="detail-candidature.php?id=124" class="lien-etendu">Voir détails</a>
          </article>
      </div>

      <nav aria-label="Pagination" style="margin-top: 2rem; display: flex; gap: 0.5rem;">
        <button type="button" disabled style="opacity: 0.5;">Précédent</button>
        <button type="button" class="btn-cta" style="padding: 5px 10px;">1</button>
        <button type="button" style="padding: 5px 10px; background: var(--surface); border: 1px solid var(--border);">Suivant</button>
      </nav>
    </section>
  </main-content>

</div>

<?php include 'includes/footer.php'; ?>