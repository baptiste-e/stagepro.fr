<main>
    <section class="hero">
        <h1>Trouvez le stage qui propulsera votre carrière</h1>
        <a href="offres.php" class="btn-cta">Explorer les offres</a>
    </section>

    <section>
        <h2>Espaces utilisateurs</h2>
        <div class="container-espaces">
            <?php foreach ($espaces as $espace) : ?>
                <article class="card <?php echo $espace['classe']; ?>">
                    <h3><?php echo $espace['titre']; ?></h3>
                    <p><?php echo $espace['desc']; ?></p>
                    <a href="<?php echo $espace['lien']; ?>" class="lien-etendu">Accéder</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <h2>Offres à la une</h2>
        <div class="grid-offres">
            <?php foreach ($offres as $offre) : ?>
                <article class="card <?php echo $offre['classe']; ?>">
                    <h3><?php echo $offre['titre']; ?></h3>
                    <p>Entreprise : <?php echo $offre['entreprise']; ?></p>
                    <a href="offres.php?id=<?php echo $offre['id']; ?>" class="lien-etendu">Voir l'offre</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>