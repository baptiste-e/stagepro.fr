<?php
// app/Controllers/WishlistController.php
require_once __DIR__ . '/../Models/Wishlist.php';

class WishlistController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new Wishlist();
        $this->twig = $twig;
    }

    public function index() {
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }
        $wishlist = $this->model->getUserWishlist($_SESSION['user']['id']);
        echo $this->twig->render('wishlist/liste.html.twig', [
            'wishlist' => $wishlist,
            'titre_page' => "Ma Wish-list | StagePro"
        ]);
    }

    public function add() {
        $id_offre = (int)($_POST['id_offre'] ?? 0);
        if ($id_offre > 0 && isset($_SESSION['user'])) {
            $this->model->add($_SESSION['user']['id'], $id_offre);
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=offres'));
        exit;
    }

    public function remove() {
        $id_offre = (int)($_REQUEST['id_offre'] ?? 0);
        if ($id_offre > 0 && isset($_SESSION['user'])) {
            $this->model->remove($_SESSION['user']['id'], $id_offre);
        }
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=wishlist'));
        exit;
    }
}