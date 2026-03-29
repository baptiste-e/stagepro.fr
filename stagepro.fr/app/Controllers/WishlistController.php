<?php
// app/Controllers/WishlistController.php
require_once __DIR__ . '/../Models/Wishlist.php';

class WishlistController {
    private $model;
    private $twig;

    /**
     * Le constructeur reçoit l'instance Twig et initialise le modèle
     */
    public function __construct($twig) {
        $this->model = new Wishlist();
        $this->twig = $twig;
    }

    /**
     * Affiche la liste des favoris (Wish-list) de l'étudiant
     */
    public function index() {
        // Sécurité : redirection si non connecté
        if (!isset($_SESSION['user'])) { 
            header('Location: index.php?page=login'); 
            exit; 
        }
        
        $id_user = (int)$_SESSION['user']['id'];
        
        // Récupération de la liste via le modèle
        $wishlist = $this->model->getUserWishlist($id_user);
        
        // On conserve la variable sémantique de tes collègues pour la vue
        $wishlist_est_vide = empty($wishlist);
        
        echo $this->twig->render('wishlist/liste.html.twig', [
            'wishlist' => $wishlist,
            'wishlist_est_vide' => $wishlist_est_vide,
            'titre_page' => "Ma Wish-list | StagePro"
        ]);
    }

    /**
     * Ajoute une offre à la wish-list
     */
    public function add() {
        if (!isset($_SESSION['user'])) { 
            header('Location: index.php?page=login'); 
            exit; 
        }

        $id_offre = (int)($_POST['id_offre'] ?? 0);
        $id_user = (int)$_SESSION['user']['id'];

        if ($id_offre > 0) {
            $this->model->add($id_user, $id_offre);
        }

        // Redirection vers la page précédente (Referer) ou par défaut vers les offres
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=offres'));
        exit;
    }

    /**
     * Supprime une offre de la wish-list
     */
    public function remove() {
        if (!isset($_SESSION['user'])) { 
            header('Location: index.php?page=login'); 
            exit; 
        }

        // On accepte POST ou GET (REQUEST) pour plus de souplesse selon le bouton cliqué
        $id_offre = (int)($_REQUEST['id_offre'] ?? 0);
        $id_user = (int)$_SESSION['user']['id'];

        if ($id_offre > 0) {
            $this->model->remove($id_user, $id_offre);
        }

        // Redirection vers la page précédente ou par défaut vers la wishlist
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=wishlist'));
        exit;
    }
}