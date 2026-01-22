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

    public function redeem()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /loyality_point_system/public/rewards');
            exit;
        }

        $reward_id = $_POST['reward_id'] ?? null;
        if (!$reward_id) {
            header('Location: /loyality_point_system/public/rewards');
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);
        $reward = $this->rewardModel->getById($reward_id);

        if (!$reward || $user['total_points'] < $reward['points_required']) {
            header('Location: /loyality_point_system/public/rewards');
            exit;
        }

        // Redeem
        $this->rewardModel->redeem($reward_id);
        $this->userModel->addTransaction($_SESSION['user_id'], 'redeemed', -$reward['points_required'], 'Échange contre ' . $reward['name']);

        header('Location: /loyality_point_system/public/rewards');
        exit;
    }
}
