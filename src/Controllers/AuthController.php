<?php

namespace App\Controllers;


use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class AuthController
{
    private $twig;
    private User $user;

    function __construct(){
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader,['cache' => false]);
        $this->user = new User();
    }
    function showRegister(){
        echo $this->twig->render('auth/register.twig' , [
            'session' => $_SESSION
            ]);
        
    }
    function register(){
        if($_SERVER['REQUEST_METHOD']== 'POST'){
          $name = $_POST['name'];  
          $email = $_POST['email'];  
          $password = $_POST['password'];  

          if($this->user->create($email , $password , $name)){
            header('location: /loyality_point_system/public/login');
            exit;
          }
        }
    }
    function showLogin(){
        echo $this->twig->render('auth/login.twig',[
            'session' => $_SESSION]);
        
    }
    function login(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
          $email = $_POST['email'];  
          $password = $_POST['password'];
          
          $user = $this->user->login($email , $password);

          if($user){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('location: /loyality_point_system/public/dashboard');
            exit;
          }
        }
        $this->showLogin();
    }
    function logout() {
        session_destroy();
        header('location: /loyality_point_system/public/');
        exit;
    }    
}


