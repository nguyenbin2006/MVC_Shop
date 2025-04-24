<?php
require_once __DIR__ . '/../Model/ProductModel.php';
class ProductController
{
    public function index()
    {
        $product = new ProductModel();
        $productList = $product->getAllProducts();
        include __DIR__ . '/../Views/Product/index.php';
    }
    public function create()
    {
        include __DIR__ . '/../Views/Product/create.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] ==='POST' &&
            isset($_POST['ProductID'])
        )
        {
            $productId = $_POST['ProductID'];
            $product = new ProductModel();
            $product->deleteProduct($productId);    
            
        }
        // Chuyển hướng về trang danh sách
        header("Location:index");
        exit;
    }

    public function store()
    {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $image = '';

        // Xử lý upload ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = time() . '_' . basename($_FILES['image']['name']);
            
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image);
        }

        // Gọi Model để lưu
        $product = new ProductModel();
        $product->insertProduct($name, $price, $image);

        // Chuyển hướng về trang danh sách
        header("Location:index");
        exit;
    }
}
