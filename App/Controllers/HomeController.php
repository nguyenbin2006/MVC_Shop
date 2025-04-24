<?php
require_once __DIR__ . '/../Model/ProductModel.php';
class HomeController
{
    public function index()
    {
        $product = new ProductModel();
        $productList = $product->getAllProducts();
         include 'app/views/home.php';
    }
}
