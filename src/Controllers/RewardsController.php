<?php

namespace App\Controllers;

use App\Models\Reward;
use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RewardsController
{
    private $twig;
    private $rewardModel;
    private $userModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /loyality_point_system/public/login');
            exit;
        }

        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, ['cache' => false]);

        $this->rewardModel = new Reward();
        $this->userModel = new User();
    }

    public function index()
    {
        $rewards = $this->rewardModel->getAll();
        $user = $this->userModel->findById($_SESSION['user_id']);

        echo $this->twig->render('rewards/index.twig', [
            'rewards' => $rewards,
            'user' => $user,
            'session' => $_SESSION
        ]);
    }
}
