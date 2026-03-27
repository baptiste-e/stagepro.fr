<div style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
    <nav style="margin-bottom: 2rem; font-size: 0.8rem; color: #666;">
        <a href="index.php?page=offres" style="color: #2563eb; text-decoration: none;">&larr; Retour aux offres</a>
    </nav>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
        <article>
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($offre['titre']) ?></h1>
            <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 2rem;"><?= htmlspecialchars($offre['entreprise_nom']) ?></p>

            <section style="margin-bottom: 2.5rem;">
                <h3 style="border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Description du poste</h3>
                <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($offre['description'])) ?></p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h3 style="border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Compétences recherchées</h3>
                <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($offre['competences'] ?: 'Non spécifiées')) ?></p>
            </section>

            <section style="margin-top: 4rem; padding: 2rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <?php if (isset($maCandidature) && $maCandidature): ?>
                    <div style="border-left: 4px solid #2563eb; padding-left: 1.5rem;">
                        <h2 style="color: #1e293b; margin-bottom: 1rem;">Vous avez déjà postulé</h2>
                        <p style="margin-bottom: 1rem;"><strong>Votre lettre de motivation :</strong></p>
                        <blockquote style="font-style: italic; color: #475569; margin-bottom: 1.5rem; background: white; padding: 1rem; border-radius: 6px;">
                            "<?= nl2br(htmlspecialchars($maCandidature['lettre_motivation'])) ?>"
                        </blockquote>
                        <?php if($maCandidature['cv']): ?>
                            <a href="<?= htmlspecialchars($maCandidature['cv']) ?>" target="_blank" 
                               style="display: inline-block; background: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                               📄 Voir le CV envoyé
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h2 style="margin-bottom: 1.5rem;">Postuler à cette offre</h2>
                    <form action="index.php?page=postuler" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_offre" value="<?= (int)$offre['id'] ?>">
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Votre CV (Format PDF)</label>
                            <input type="file" name="cv" accept=".pdf" required style="width: 100%;">
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Lettre de motivation</label>
                            <textarea name="lm" rows="6" required style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #cbd5e1;"></textarea>
                        </div>
                        <button type="submit" style="background: #1e293b; color: white; padding: 1rem 2rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; width: 100%;">Envoyer ma candidature</button>
                    </form>
                <?php endif; ?>
            </section>
        </article>

        <aside>
            <div style="background: white; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
                <h3 style="font-size: 0.875rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Détails du stage</h3>
                <p style="margin-bottom: 0.75rem;"><strong>📍 Lieu :</strong> <?= htmlspecialchars($offre['localite']) ?></p>
                <p style="margin-bottom: 0.75rem;"><strong>⏳ Durée :</strong> <?= htmlspecialchars($offre['duree']) ?></p>
                <p style="margin-bottom: 0.75rem;"><strong>💰 Gratification :</strong> <?= number_format($offre['remuneration'], 2, ',', ' ') ?> €/mois</p>
                <p><strong>👥 Places :</strong> <?= (int)$offre['nb_places'] ?> poste(s)</p>
            </div>

            <?php 
            $role = strtolower($_SESSION['user']['role_nom'] ?? $_SESSION['user']['role'] ?? '');
            ?>

            <?php if ($role === 'etudiant'): ?>
                <div style="padding: 1.5rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 0.875rem; color: #334155; margin-bottom: 1rem;">Favoris</h3>
                    <form action="index.php?page=wishlist-add" method="post" style="margin: 0;">
                        <input type="hidden" name="id_offre" value="<?= (int)$offre['id'] ?>">
                        <button type="submit" style="width: 100%; background: transparent; border: 1px solid #2563eb; color: #2563eb; padding: 0.75rem; border-radius: 6px; cursor: pointer; font-weight: 600;">
                            ☆ Ajouter à ma wish-list
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($role === 'admin' || $role === 'pilote'): ?>
                <div style="padding: 1.5rem; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px;">
                    <h3 style="font-size: 0.875rem; color: #be123c; margin-bottom: 1rem;">Administration</h3>
                    <a href="index.php?page=offre-edit&id=<?= (int)$offre['id'] ?>" 
                       style="display: block; text-align: center; background: #1e293b; color: white; padding: 0.75rem; border-radius: 6px; text-decoration: none; margin-bottom: 0.5rem;">Modifier</a>
                    
                    <form action="index.php?page=offre-delete" method="post" onsubmit="return confirm('Supprimer définitivement cette offre ?');">
                        <input type="hidden" name="id" value="<?= (int)$offre['id'] ?>">
                        <button type="submit" style="width: 100%; background: #e11d48; color: white; padding: 0.75rem; border: none; border-radius: 6px; cursor: pointer;">Supprimer</button>
                    </form>
                </div>
            <?php elseif ($role === 'etudiant' && isset($maCandidature) && $maCandidature): ?>
                <div style="text-align: center;">
                    <a href="index.php?page=candidatures" class="btn-cta">Voir mes candidatures</a>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</div>