<?php

$config = require_once './config.php';
require_once './App/Model/UserModel.php';

class UserController
{
    public function index()
    {
        include __DIR__ . '/../Views/User/index.php';
    }

    public function register()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        $error = '';
        $userModel = new UserModel();
        $config = require './config.php';
        $baseURL = $config['baseURL'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $userId = $userModel->createUser($fullname, $username, $password);
                
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;

                header("Location: " . $baseURL. 'home/index');
                exit;
        }
        include './App/Views/User/register.php';
    }   

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $pdo = new PDO("mysql:host=localhost;dbname=productdb", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $config = require 'config.php';
                $baseURL = $config['baseURL'];
                header("Location: " . $baseURL . 'home/index');// về trang chủ
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }
        include './App/Views/User/login.php';
    }
}