<div style="padding: 2rem; max-width: 1100px; margin: 0 auto;">
    <nav style="margin-bottom: 2rem;">
        <a href="index.php?page=candidatures" style="color: #2563eb; text-decoration: none; font-weight: 500;">
            &larr; Retour à la liste de mes candidatures
        </a>
    </nav>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
        
        <article>
            <h1 style="font-size: 2.2rem; margin-bottom: 0.5rem; color: #1e293b;"><?= htmlspecialchars($candidature['offre_titre']) ?></h1>
            <p style="font-size: 1.3rem; color: #64748b; margin-bottom: 2.5rem;"><?= htmlspecialchars($candidature['entreprise_nom']) ?></p>

            <section style="background: #ffffff; padding: 2.5rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.4rem; margin-bottom: 2rem; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.8rem;">Mon Dossier de Candidature</h2>
                
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 1rem; text-transform: uppercase; font-size: 0.85rem;">Ma lettre de motivation :</label>
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; border: 1px solid #cbd5e1; line-height: 1.7; color: #334155; font-style: italic;">
                        "<?= nl2br(htmlspecialchars($candidature['lettre_motivation'])) ?>"
                    </div>
                </div>

                <?php if ($candidature['cv']): ?>
                    <div>
                        <label style="display: block; font-weight: 700; color: #475569; margin-bottom: 1rem; text-transform: uppercase; font-size: 0.85rem;">Mon CV transmis :</label>
                        <a href="<?= htmlspecialchars($candidature['cv']) ?>" target="_blank" 
                           style="display: inline-flex; align-items: center; gap: 0.8rem; background: #2563eb; color: white; padding: 1rem 1.8rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
                           <span style="font-size: 1.2rem;">📄</span> Consulter mon CV (PDF)
                        </a>
                    </div>
                <?php endif; ?>
            </section>

            <section style="margin-top: 3.5rem;">
                <h3 style="color: #94a3b8; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem;">Rappel de la description du poste</h3>
                <div style="line-height: 1.8; color: #475569;">
                    <?= nl2br(htmlspecialchars($candidature['offre_desc'])) ?>
                </div>
            </section>
        </article>

        <aside>
            <div style="background: white; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; position: sticky; top: 2rem;">
                <h3 style="font-size: 0.9rem; color: #64748b; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">Récapitulatif</h3>
                
                <div style="margin-bottom: 1.2rem;">
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block;">Envoyé le :</span>
                    <span style="font-weight: 600; color: #1e293b;"><?= date('d/m/Y à H:i', strtotime($candidature['created_at'])) ?></span>
                </div>

                <div style="margin-bottom: 1.2rem;">
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block;">Localisation :</span>
                    <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($candidature['localite']) ?></span>
                </div>

                <div style="margin-bottom: 2rem;">
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block;">Gratification :</span>
                    <span style="font-weight: 600; color: #1e293b;"><?= number_format($candidature['remuneration'], 2, ',', ' ') ?> €/mois</span>
                </div>
                
                <hr style="border: 0; border-top: 1px solid #f1f5f9; margin-bottom: 2rem;">
                
                <a href="index.php?page=candidature-cancel&id=<?= $candidature['id'] ?>" 
                   onclick="return confirm('Attention : Cette action annulera définitivement votre candidature. Confirmer ?');"
                   style="display: block; text-align: center; color: #e11d48; font-weight: 700; text-decoration: none; padding: 0.9rem; border: 2px solid #e11d48; border-radius: 8px; transition: all 0.2s;">
                   Retirer ma candidature
                </a>
            </div>
        </aside>
    </div>
</div>