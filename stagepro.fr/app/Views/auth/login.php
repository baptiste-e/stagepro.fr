<section style="max-width: 500px; margin: 3rem auto; background: var(--surface); padding: 2rem; border: 1px solid var(--border); border-radius: 8px;">
    <h1>Connexion</h1>
    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Connectez-vous à votre espace StagePro.</p>

    <?php if (!empty($erreur)): ?>
        <div style="background: #ffdede; color: #a10000; padding: 12px; border-radius: 6px; margin-bottom: 1rem;">
            <?= htmlspecialchars($erreur) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=login" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <button type="submit" style="width: 100%;">Se connecter</button>
    </form>
</section>