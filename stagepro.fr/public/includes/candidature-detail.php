<?php 
  $titre_page = "Détail Candidature | StagePro";
  include 'includes/header.php'; 
?>

<nav aria-label="Fil d’ariane" style="margin-bottom: 2rem; font-size: 0.8rem;">
  <p>
    <a href="index.php" style="color: var(--accent-blue);">Accueil</a> &gt;
    <a href="candidatures.php" style="color: var(--accent-blue);">Candidatures</a> &gt;
    <span style="color: var(--text-muted);">Détail candidature</span>
  </p>
</nav>

<section>
  <h1 style="margin-bottom: 0.5rem;">Détail candidature</h1>
  <p style="color: var(--text-muted);">Informations complètes d’une candidature envoyée.</p>
</section>

<section style="margin-top: 2rem;">
  <h2 style="color: var(--accent-blue); font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
    Informations
  </h2>
  <ul style="list-style: none; line-height: 2;">
    <li><strong style="color: var(--accent-purple);">Offre :</strong> <span style="color: var(--text-main);">Développeur Fullstack #882</span></li>
    <li><strong style="color: var(--accent-purple);">Entreprise :</strong> <span style="color: var(--text-main);">TechCorp</span></li>
    <li><strong style="color: var(--accent-purple);">Étudiant :</strong> <span style="color: var(--text-main);">Jean Dupont</span></li>
    <li><strong style="color: var(--accent-purple);">Pilote :</strong> <span style="color: var(--text-main);">Mme. Martin</span></li>
    <li><strong style="color: var(--accent-purple);">Date :</strong> <span style="color: var(--text-main);">12/03/2026</span></li>
  </ul>
</section>

<section style="margin-top: 2rem;">
  <h2 style="color: var(--accent-blue); font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
    Documents
  </h2>
  <p style="font-size: 0.9rem; margin-bottom: 1rem;">CV et lettre de motivation envoyés.</p>

  <div style="margin-bottom: 1.5rem;">
    <strong style="color: var(--accent-purple);">CV :</strong> 
    <a href="uploads/cv_jean_dupont.pdf" class="btn-cta" style="padding: 5px 15px; font-size: 0.8rem; margin-left: 10px;">Télécharger / Voir</a>
  </div>

  <div class="form-group">
    <label style="color: var(--accent-purple); font-weight: bold; display: block; margin-bottom: 0.5rem;">Lettre de motivation :</label>
    <textarea rows="8" style="width: 100%; background: var(--surface); color: var(--text-main); border: 1px solid var(--border); padding: 1rem; border-radius: 6px;" readonly>Madame, Monsieur, 

Actuellement en recherche d'un stage de fin d'études, je suis très intéressé par votre offre...
    </textarea>
  </div>
</section>

<section style="margin-top: 3rem; padding: 2rem; background: rgba(255, 0, 0, 0.05); border: 1px dashed #ff4444