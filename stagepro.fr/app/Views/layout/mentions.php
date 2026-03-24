<?php 
  // On peut laisser la variable titre au cas où, mais le header et le footer 
  // sont déjà gérés par le Routeur (index.php).
?>

<section>
  <h1 style="color: var(--accent-blue); margin-bottom: 1rem;">Mentions légales</h1>
  <p style="color: var(--text-muted); border-left: 3px solid var(--accent-purple); padding-left: 1rem; font-style: italic;">
    Conformément aux dispositions des articles 6-III et 19 de la Loi n° 2004-575 du 21 juin 2004 pour la Confiance dans l'Économie Numérique (L.C.E.N.).
  </p>
</section>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
    
    <section style="background: var(--surface); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
      <h2 style="font-size: 1.2rem; margin-bottom: 1rem; color: var(--accent-purple);">Éditeur du site</h2>
      <p style="font-size: 0.9rem; line-height: 1.6;">
        Le présent site est un projet pédagogique réalisé par des étudiants du <strong>CESI</strong>.
      </p>
      <ul style="list-style: none; margin-top: 1rem; font-size: 0.85rem; color: var(--text-muted);">
        <li>• <strong>Projet :</strong> StagePro - Gestion des stages</li>
        <li>• <strong>Éditeur :</strong> Groupe Projet CESI 2026</li>
        <li>• <strong>Responsable :</strong> Équipe pédagogique</li>
      </ul>
    </section>

    <section style="background: var(--surface); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
      <h2 style="font-size: 1.2rem; margin-bottom: 1rem; color: var(--accent-purple);">Hébergement</h2>
      <p style="font-size: 0.9rem;">Environnement de développement local.</p>
      <ul style="list-style: none; margin-top: 1rem; font-size: 0.85rem; color: var(--text-muted);">
        <li>• <strong>Hébergeur :</strong> Serveur local (WAMP/Laragon/XAMPP)</li>
        <li>• <strong>Finalité :</strong> Soutenance académique</li>
      </ul>
    </section>

</div>

<section style="margin-top: 3rem;">
  <h2 style="margin-bottom: 1rem;">Données personnelles (RGPD)</h2>
  <div style="background: rgba(129, 140, 248, 0.05); padding: 2rem; border-radius: 8px; border: 1px dashed var(--border);">
      <p style="margin-bottom: 1rem;">
        Les données collectées (nom, email, CV) sont strictement limitées à l'usage interne du projet <strong>StagePro</strong>.
      </p>
      <p style="font-size: 0.9rem; color: var(--text-muted);">
        Conformément au <strong>RGPD</strong>, vous disposez d'un droit d'accès et de suppression. Étant un projet local, aucune donnée n'est revendue ou transférée à des tiers.
      </p>
  </div>
</section>

<section style="margin-top: 3rem; margin-bottom: 5rem;">
  <h2 style="margin-bottom: 1rem;">Propriété intellectuelle</h2>
  <p style="font-size: 0.9rem; color: var(--text-muted);">
    Tous les éléments (textes, logos, code source) sont la propriété de l'équipe projet. Toute reproduction sans accord préalable est interdite, sauf dans le cadre strict de l'évaluation pédagogique.
  </p>
</section>

<div style="text-align: center; margin-bottom: 3rem;">
    <a href="index.php?page=home" class="btn-cta" style="background: transparent; border: 1px solid var(--accent-blue); color: var(--accent-blue);">
        Retour à l'accueil
    </a>
</div>