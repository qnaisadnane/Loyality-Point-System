<?php
namespace App\Controllers;

use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, ['cache' => false]);
    }

    public function index() {
        $data = ['session' => $_SESSION];
        if(isset($_SESSION['user_id'])){
            $userm = new User();
            $user = $userm->findById($_SESSION['user_id']);
            $data['user'] = $user;
        }
        echo $this->twig->render('home/index.twig', $data);
    }
}