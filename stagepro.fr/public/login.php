<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'includes/db.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($motDePasse)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $sql = "SELECT utilisateurs.*, roles.nom AS role_nom
                FROM utilisateurs
                JOIN roles ON utilisateurs.role_id = roles.id
                WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $utilisateur = $stmt->fetch();

        if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            $_SESSION['user'] = [
                'id' => $utilisateur['id'],
                'nom' => $utilisateur['nom'],
                'prenom' => $utilisateur['prenom'],
                'email' => $utilisateur['email'],
                'role' => $utilisateur['role_nom']
            ];

            header('Location: index.php');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}

$titre_page = "Connexion | StagePro";
include 'includes/header.php';
?>

<section style="max-width: 500px; margin: 3rem auto; background: var(--surface); padding: 2rem; border: 1px solid var(--border); border-radius: 8px;">
    <h1 style="margin-bottom: 1rem;">Connexion</h1>
    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Connectez-vous à votre espace StagePro.</p>

    <?php if (!empty($erreur)): ?>
        <div style="background: #ffdede; color: #a10000; padding: 12px; border-radius: 6px; margin-bottom: 1rem;">
            <?= htmlspecialchars($erreur) ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <div class="form-group" style="margin-bottom: 1rem;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group" style="margin-bottom: 1rem;">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit" style="width: 100%;">Se connecter</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>