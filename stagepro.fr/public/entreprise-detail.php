<?php 
  $titre_page = "Fiche Entreprise | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="entreprises.php" style="color: var(--accent-blue);">Entreprises</a> &gt;
    <span style="color: var(--text-muted);">Fiche entreprise</span>
  </p>
</nav>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
  
  <div class="main-column">
    <section>
      <h1 style="margin-bottom: 1rem; color: var(--accent-blue);">TechCorp SAS</h1>
      <p style="font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
        Leader dans le domaine des solutions logicielles innovantes, TechCorp accompagne les entreprises dans leur transformation digitale.
      </p>

      <div style="background: var(--surface); border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informations de contact</h2>
        <ul style="list-style: none; line-height: 2.2;">
          <li><strong style="color: var(--accent-purple);">Email :</strong> contact@techcorp.com</li>
          <li><strong style="color: var(--accent-purple);">Téléphone :</strong> 01 23 45 67 89</li>
          <li><strong style="color: var(--accent-purple);">Localisation :</strong> Lyon, France</li>
        </ul>
      </div>
    </section>

    <section style="margin-top: 3rem;">
      <h2 style="margin-bottom: 1.5rem;">Offres de stage associées</h2>
      <div class="grid-offres">
        <article class="card">
          <h3>Développeur Fullstack</h3>
          <p>6 mois - Lyon</p>
          <a href="detail-offre.php?id=101" class="lien-etendu">Voir l'offre</a>
        </article>
      </div>
    </section>
  </div>

  <aside class="side-column">
    <div style="background: var(--surface-hover); border: 1px solid var(--accent-blue); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
      <h2 style="font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">Statistiques</h2>
      <p style="font-size: 2rem; font-weight: bold; color: var(--accent-blue);">4.5 <span style="font-size: 1rem; color: var(--text-muted);">/ 5</span></p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">Basé sur 12 évaluations</p>
      <hr style="border: 0; border-top: 1px solid var(--border); margin: 1rem 0;">
      <p><strong>Candidatures :</strong> 24 reçues</p>
    </div>

    <div style="margin-bottom: 2rem;">
      <a href="formulaire-entreprise.php?id=12" class="btn-cta" style="display: block; text-align: center; margin-bottom: 0.5rem;">Modifier la fiche</a>
      <button type="button" style="width: 100%; background: #ff4444; color: white;">Supprimer</button>
    </div>
  </aside>
</div>

<section style="margin-top: 4rem; border-top: 1px solid var(--border); padding-top: 2rem;">
  <h2>Évaluations des étudiants</h2>
  <div style="margin: 2rem 0;">
    <div style="background: var(--surface); padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
      <p><strong style="color: var(--accent-blue);">★★★★☆</strong> - "Super ambiance et projets intéressants."</p>
      <p style="font-size: 0.8rem; color: var(--text-muted);">- Étudiant anonyme, Mars 2026</p>
    </div>
  </div>

  <div style="max-width: 600px; background: var(--surface); padding: 2rem; border-radius: 8px;">
    <h3>Évaluer cette entreprise</h3>
    <form action="traitement-avis.php" method="post" style="margin-top: 1rem;">
      <div class="form-group">
        <label for="note">Note (sur 5)</label>
        <select id="note" name="note" required>
          <option value="">Sélectionner une note</option>
          <option value="5">5 - Excellent</option>
          <option value="4">4 - Très bien</option>
          <option value="3">3 - Moyen</option>
          <option value="2">2 - Décevant</option>
          <option value="1">1 - À éviter</option>
        </select>
      </div>

      <div class="form-group">
        <label for="commentaire">Votre commentaire</label>
        <textarea id="commentaire" name="commentaire" rows="4" placeholder="Partagez votre expérience..."></textarea>
      </div>

      <button type="submit">Envoyer mon avis</button>
    </form>
  </div>
</section>

<?php include 'includes/footer.php'; ?>