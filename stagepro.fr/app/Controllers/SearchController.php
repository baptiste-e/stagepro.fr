<?php
require_once __DIR__ . '/../Models/Offre.php';
require_once __DIR__ . '/../Models/Entreprise.php';

class SearchController
{
    private Offre $offreModel;
    private Entreprise $entrepriseModel;
    private $twig;

    public function __construct($twig)
    {
        $this->offreModel = new Offre();
        $this->entrepriseModel = new Entreprise();
        $this->twig = $twig;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');

        if ($query === '') {
            header('Location: index.php?page=home');
            exit;
        }

        $normalized = mb_strtolower($query);

        $navigationMap = [
            'accueil' => 'home',
            'home' => 'home',
            'offres' => 'offres',
            'offre' => 'offres',
            'entreprises' => 'entreprises',
            'entreprise' => 'entreprises',
            'wishlist' => 'wishlist',
            'wish-list' => 'wishlist',
            'wish list' => 'wishlist',
            'candidatures' => 'candidatures',
            'candidature' => 'candidatures',
            'connexion' => 'login',
            'login' => 'login',
        ];

        if (isset($navigationMap[$normalized])) {
            header('Location: index.php?page=' . $navigationMap[$normalized]);
            exit;
        }

        $offres = $this->offreModel->searchGlobal($query);
        $entreprises = $this->entrepriseModel->searchGlobal($query);

        echo $this->twig->render('recherche.html.twig', [
            'query' => $query,
            'offres' => $offres,
            'entreprises' => $entreprises,
            'titre_page' => 'Recherche : ' . htmlspecialchars($query) . ' | StagePro'
        ]);
    }
}