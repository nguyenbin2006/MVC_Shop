<?php
require_once __DIR__ .'/../Model/OrderModel.php';
require_once __DIR__ .'/../Model/ProductModel.php';
class OrderController
{
    public function checkout()
   {
        if (session_status() === PHP_SESSION_NONE) {
           session_start();
        }
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $product = $productModel->getProductById($item['product_id']);
                $total += $product['Price'] * $item['quantity'];
            }

        $orderId = $orderModel->createOrder($_SESSION['user_id'], $total);
        foreach ($_SESSION['cart'] as $item) {
            $product = $productModel->getProductById($item['product_id']);
            $orderModel->addOrderItem($orderId, $item['product_id'], 
                                $item['quantity'], $product['Price']);
        }
        
        unset($_SESSION['cart']);
        include './App/Views/Order/checkout_success.php';
   }

   public function history()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $config = require './config.php';
            header("Location: " . $config['baseURL'] . "user/login");
            exit;
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersByUserId($_SESSION['user_id']);

        $config = require './config.php';
        $baseURL = $config['baseURL'];

        include './App/Views/Order/history.php';
}
}