<?php
/**
 * VUE : Page d'accueil (Home)
 * Ce fichier est inclus par le Routeur entre le header et le footer.
 */
?>

<section class="hero">
    <h1>Trouvez le stage qui propulsera votre carrière</h1>
    <a href="index.php?page=offres" class="btn-cta">Explorer les offres</a>
</section>

<section class="entreprise-showcase">
  <div class="entreprise-showcase-header">
    <p class="showcase-eyebrow">Paroles d’entreprises</p>
    <h2>Pourquoi les entreprises recrutent des stagiaires</h2>
    <p class="showcase-intro">
      Découvrez comment les stages permettent aux entreprises de transmettre,
      d’innover et de préparer les talents de demain.
    </p>
  </div>

  <div class="testimonial-slider">
    <div class="testimonial-track">

      <article class="testimonial-card active">
        <p class="testimonial-quote">
          “Accueillir des stagiaires nous permet de transmettre notre savoir-faire,
          d’identifier de nouveaux talents et d’apporter un regard neuf sur nos projets.”
        </p>

        <div class="testimonial-meta">
          <strong>Sophie Martin</strong>
          <span>Responsable RH · TechCorp</span>
        </div>
      </article>

      <article class="testimonial-card">
        <p class="testimonial-quote">
          “Les stagiaires apportent de nouvelles idées, une vraie énergie d’apprentissage
          et deviennent souvent des profils que nous souhaitons accompagner sur le long terme.”
        </p>

        <div class="testimonial-meta">
          <strong>Lucas Bernard</strong>
          <span>Directeur de création · CreativeLab</span>
        </div>
      </article>

      <article class="testimonial-card">
        <p class="testimonial-quote">
          “Recruter un stagiaire, c’est investir dans l’avenir de l’entreprise tout en
          renforçant nos équipes sur des missions concrètes et utiles.”
        </p>

        <div class="testimonial-meta">
          <strong>Nadia El Amrani</strong>
          <span>Manager Data · DataFlow</span>
        </div>
      </article>

    </div>

    <div class="testimonial-progress">
      <span class="testimonial-progress-bar"></span>
    </div>
  </div>
</section>

<section>
    <h2>Espaces utilisateurs</h2>
    <div class="container-espaces">
        <article class="card card-etudiant">
            <h3>Espace étudiant</h3>
            <p>Consulter les offres, postuler et suivre vos candidatures.</p>
            <a href="index.php?page=etudiants" class="lien-etendu"></a>
        </article>

        <article class="card card-pilote">
            <h3>Espace pilote</h3>
            <p>Suivre les candidatures, consulter les offres et accompagner les étudiants.</p>
            <a href="index.php?page=pilotes" class="lien-etendu"></a>
        </article>

        <article class="card card-admin">
            <h3>Espace Admin</h3>
            <p>Gestion des comptes, des entreprises et administration globale.</p>
            <a href="index.php?page=admin" class="lien-etendu"></a>
        </article>
    </div>
</section>

<section>
    <h2>Offres à la une</h2>
    <div class="grid-offres">
        <article class="card card-dev_web">
            <h3>Développeur Web</h3>
            <p>Entreprise : TechCorp</p>
            <a href="index.php?page=offres" class="lien-etendu"></a>
        </article>

        <article class="card card-data_analyst">
            <h3>Data Analyst</h3>
            <p>Entreprise : DataFlow</p>
            <a href="index.php?page=offres" class="lien-etendu"></a>
        </article>

        <article class="card card-UI_UX_designer">
            <h3>UI/UX Designer</h3>
            <p>Entreprise : CreativeLab</p>
            <a href="index.php?page=offres" class="lien-etendu"></a>
        </article>
    </div>
</section>