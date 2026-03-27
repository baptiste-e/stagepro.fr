<?php
$role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');

function statutInfos($statut) {
    switch ($statut) {
        case 'acceptee':
            return ['label' => 'Acceptée', 'bg' => '#dcfce7', 'color' => '#166534'];
        case 'refusee':
            return ['label' => 'Refusée', 'bg' => '#fee2e2', 'color' => '#991b1b'];
        default:
            return ['label' => 'En attente', 'bg' => '#fef3c7', 'color' => '#92400e'];
    }
}

$badge = statutInfos($candidature['statut'] ?? 'en_attente');
?>

<div style="padding: 2rem; max-width: 1100px; margin: 0 auto;">
    <nav style="margin-bottom: 2rem;">
        <a href="index.php?page=candidatures" style="color: #2563eb; text-decoration: none; font-weight: 500;">
            &larr; Retour à la liste des candidatures
        </a>
    </nav>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">

        <article>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                <div>
                    <h1 style="font-size: 2.2rem; margin-bottom: 0.5rem; color: #1e293b;"><?= htmlspecialchars($candidature['offre_titre']) ?></h1>
                    <p style="font-size: 1.3rem; color: #64748b; margin-bottom: 1.5rem;"><?= htmlspecialchars($candidature['entreprise_nom']) ?></p>
                </div>

                <span style="background: <?= $badge['bg'] ?>; color: <?= $badge['color'] ?>; padding: 8px 14px; border-radius: 999px; font-size: 0.85rem; font-weight: 700;">
                    <?= $badge['label'] ?>
                </span>
            </div>

            <section style="background: #ffffff; padding: 2.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.4rem; margin-bottom: 2rem; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.8rem;">Dossier de candidature</h2>

                <?php if (in_array($role, ['admin', 'pilote'], true)): ?>
                    <div style="margin-bottom: 2rem; padding: 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <p style="margin-bottom: 0.4rem;"><strong>Candidat :</strong> <?= htmlspecialchars(($candidature['prenom'] ?? '') . ' ' . ($candidature['nom'] ?? '')) ?></p>
                        <p style="margin: 0;"><strong>ID utilisateur :</strong> <?= (int)$candidature['utilisateur_id'] ?></p>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 1.2rem;">
                    <strong>Date d’envoi :</strong>
                    <?= !empty($candidature['created_at']) ? date('d/m/Y à H:i', strtotime($candidature['created_at'])) : 'Non renseignée' ?>
                </div>

                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 1rem; text-transform: uppercase; font-size: 0.85rem;">Lettre de motivation :</label>
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; border: 1px solid #cbd5e1; line-height: 1.7; color: #334155; font-style: italic;">
                        "<?= nl2br(htmlspecialchars($candidature['lettre_motivation'])) ?>"
                    </div>
                </div>

                <?php if (!empty($candidature['cv'])): ?>
                    <div>
                        <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 1rem; text-transform: uppercase; font-size: 0.85rem;">CV transmis :</label>
                        <a href="<?= htmlspecialchars($candidature['cv']) ?>" target="_blank"
                           style="display: inline-flex; align-items: center; gap: 0.8rem; background: #2563eb; color: white; padding: 1rem 1.8rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                           <span style="font-size: 1.2rem;">📄</span> Consulter le CV (PDF)
                        </a>
                    </div>
                <?php endif; ?>
            </section>

            <section style="margin-top: 3.5rem;">
                <h3 style="color: #94a3b8; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem;">Rappel de la description du poste</h3>
                <div style="line-height: 1.8; color: #334155; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem;">
                    <?= nl2br(htmlspecialchars($candidature['offre_desc'] ?? 'Aucune description disponible.')) ?>
                </div>
            </section>
        </article>

        <aside>
            <div style="background: #ffffff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
                <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Informations</h3>
                <p style="margin-bottom: 0.75rem;"><strong>📍 Lieu :</strong> <?= htmlspecialchars($candidature['localite'] ?? 'Non renseigné') ?></p>
                <p><strong>💰 Gratification :</strong>
                    <?= isset($candidature['remuneration']) && $candidature['remuneration'] !== null
                        ? number_format((float)$candidature['remuneration'], 2, ',', ' ') . ' €/mois'
                        : 'Non renseignée' ?>
                </p>
            </div>

            <?php if (in_array($role, ['admin', 'pilote'], true)): ?>
                <div style="background: #ffffff; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Mettre à jour le statut</h3>

                    <form action="index.php?page=candidature-update-status&id=<?= (int)$candidature['id'] ?>" method="post">
                        <select name="statut" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #cbd5e1; margin-bottom: 1rem;">
                            <option value="en_attente" <?= ($candidature['statut'] ?? '') === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                            <option value="acceptee" <?= ($candidature['statut'] ?? '') === 'acceptee' ? 'selected' : '' ?>>Acceptée</option>
                            <option value="refusee" <?= ($candidature['statut'] ?? '') === 'refusee' ? 'selected' : '' ?>>Refusée</option>
                        </select>

                        <button type="submit" class="btn-cta" style="width: 100%;">Enregistrer le statut</button>
                    </form>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</div>