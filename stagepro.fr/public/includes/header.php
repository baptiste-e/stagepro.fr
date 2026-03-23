<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titre_page ?? 'StagePro'; ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>StagePro</h1>
    <nav aria-label="Navigation principale">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="offres.php">Offres</a></li>
            <li><a href="candidatures.php">Candidatures</a></li>
            <li><a href="entreprises.php">Entreprises</a></li>
            <li><a href="etudiant.php">Étudiants</a></li>
            <li><a href="pilote.php">Pilotes</a></li>
            <li><a href="wish-list.php">Wish-List</a></li>
        </ul>
    </nav>
  </header>
  <main id="contenu">