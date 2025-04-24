<?php
$config = require_once './config.php';
class AdminController
{
    public function dashboard()
    {

        include './App/Views/Admin/dashboard.php';
    }
}