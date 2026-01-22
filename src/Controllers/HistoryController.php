<?php

namespace App\Controllers;

use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HistoryController
{
    private $twig;
    private $userm;

    function __construct(){
        if(!isset($_SESSION['user_id'])){
        header('Location: /loyality_point_system/public/login');
        exit;
        }

        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader,['cache' => false]);
        $this->userm = new User();
    }
    function index()
{
    $user = $this->userm->findById($_SESSION['user_id']);
    $transactions = $this->userm->getTransactions($_SESSION['user_id']);

    echo $this->twig->render('dashboard/history.twig', [
        'user' => $user,
        'transactions' => $transactions,
        'session' => $_SESSION
    ]);
}
}