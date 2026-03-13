<?php 
  $titre_page = "Accueil | Plateforme de stages";
  include 'includes/header.php'; 
?>

<section class="hero">
  <h1>Trouvez le stage qui propulsera votre carrière</h1>
  <a href="offres.php" class="btn-cta">Explorer les offres</a>
</section>

<section>
  <h2>Espaces utilisateurs</h2>
  <div class="container-espaces">
      <article class="card card-etudiant">
        <h3>Espace étudiant</h3>
        <p>Consulter les offres, postuler et suivre vos candidatures.</p>
        <a href="etudiant.php" class="lien-etendu">Accéder à l’espace étudiant</a>
      </article>

      <article class="card card-pilote">
        <h3>Espace pilote</h3>
        <p>Suivre les candidatures, consulter les offres et accompagner les étudiants.</p>
        <a href="pilote.php" class="lien-etendu">Accéder à l’espace pilote</a>
      </article>

      <article class="card card-admin">
        <h3>Espace Admin</h3>
        <p>Gestion des comptes, des entreprises et administration globale.</p>
        <a href="admin.php" class="lien-etendu">Accéder à l’espace admin</a>
      </article>
  </div>
</section>

<section>
  <h2>Offres à la une</h2>
  <div class="grid-offres">
    <article class="card"><h3>Développeur Web</h3><p>Entreprise : TechCorp</p></article>
    <article class="card"><h3>Data Analyst</h3><p>Entreprise : DataFlow</p></article>
    <article class="card"><h3>UI/UX Designer</h3><p>Entreprise : CreativeLab</p></article>
  </div>
</section>

<?php include 'includes/footer.php'; ?>