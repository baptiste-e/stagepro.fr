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