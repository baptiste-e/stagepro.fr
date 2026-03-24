<?php
require 'includes/auth.php';
require 'includes/db.php';

$utilisateurId = $_SESSION['user']['id'];

$sql = "SELECT candidatures.*, 
               offres.titre AS offre_titre,
               entreprises.nom AS entreprise_nom
        FROM candidatures
        JOIN offres ON candidatures.offre_id = offres.id
        JOIN entreprises ON offres.entreprise_id = entreprises.id
        WHERE candidatures.utilisateur_id = :utilisateur_id
        ORDER BY candidatures.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':utilisateur_id', $utilisateurId, PDO::PARAM_INT);
$stmt->execute();

$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titre_page = "Mes Candidatures | StagePro";
include 'includes/header.php';
?>

<section>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1>Mes candidatures</h1>
      <p style="color: var(--text-muted);">
        Retrouvez ici les offres auxquelles vous avez postulé.
      </p>
    </div>
  </div>
</section>

<section style="margin-top: 2rem;">
  <?php if (empty($candidatures)): ?>
    <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
      <p>Vous n'avez encore postulé à aucune offre.</p>
      <a href="offres.php" class="btn-cta" style="display: inline-block; margin-top: 1rem;">Voir les offres</a>
    </div>
  <?php else: ?>
    <div class="container-espaces" style="margin-top: 1.5rem;">
      <?php foreach ($candidatures as $candidature): ?>
        <article class="card">
          <h3 style="color: var(--accent-blue);">
            <?= htmlspecialchars($candidature['offre_titre']) ?>
          </h3>

          <p><strong>Entreprise :</strong> <?= htmlspecialchars($candidature['entreprise_nom']) ?></p>

          <p style="margin-top: 0.75rem;">
            <strong>Lettre de motivation :</strong><br>
            <?= nl2br(htmlspecialchars($candidature['lettre_motivation'])) ?>
          </p>

          <p style="margin-top: 0.75rem;">
            <strong>CV :</strong>
            <?php if (!empty($candidature['cv'])): ?>
              <a href="<?= htmlspecialchars($candidature['cv']) ?>" target="_blank">Voir le CV</a>
            <?php else: ?>
              Non disponible
            <?php endif; ?>
          </p>

          <p style="margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
            Candidature envoyée le <?= htmlspecialchars($candidature['created_at']) ?>
          </p>

          <a href="detail-offre.php?id=<?= (int) $candidature['offre_id'] ?>" class="lien-etendu"></a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>