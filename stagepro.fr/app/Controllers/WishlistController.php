<?php
// app/Controllers/WishlistController.php
require_once __DIR__ . '/../Models/Wishlist.php';

class WishlistController {
    private $model;

    public function __construct() {
        $this->model = new Wishlist();
    }

    // Affiche la liste des favoris
    public function index() {
        if (!isset($_SESSION['user'])) { 
            header('Location: index.php?page=login'); 
            exit; 
        }
        
        $id_user = $_SESSION['user']['id'];
        
        // --- CHANGEMENT ICI : On utilise les noms attendus par la vue ---
        $wishlist = $this->model->getUserWishlist($id_user);
        $wishlist_est_vide = empty($wishlist);
        
        $titre_page = "Ma Wish-list | StagePro";

        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/wishlist/liste.php'; 
        include __DIR__ . '/../Views/layout/footer.php';
    }

    // Ajoute une offre aux favoris
    public function add() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }

        $id_offre = (int)($_POST['id_offre'] ?? 0);
        $id_user = $_SESSION['user']['id'];

        if ($id_offre > 0) {
            $this->model->add($id_user, $id_offre);
        }

        // Redirection vers la page précédente
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=offres'));
        exit;
    }

    // Supprime une offre des favoris
    public function remove() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }

        // On accepte POST (depuis le bouton de la liste) ou REQUEST
        $id_offre = (int)($_REQUEST['id_offre'] ?? 0);
        $id_user = $_SESSION['user']['id'];

        if ($id_offre > 0) {
            $this->model->remove($id_user, $id_offre);
        }

        // Si on vient de la liste, on y retourne, sinon page précédente
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=wishlist'));
        exit;
    }
}