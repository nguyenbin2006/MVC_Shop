<?php
foreach (glob("App/Controllers/*.php") as $filename) {
    require_once $filename;
}
$url = $_GET['url'];
$urlArr = explode('/', $url);
// var_dump($urlArr);
// die;
// echo $url;
$controlerClassName = $urlArr[0] . "Controller";
$controller = new $controlerClassName();
call_user_func([$controller, $urlArr[1]]);
// if ($urlArr[0] == 'product') {
//     $controler = new ProductController();
//     if ($urlArr[1] == "create") {
//         $controler->index();
//     } else
//         $controler->index();
// } elseif ($urlArr[0] == 'user') {
//     $controler = new UserController();
//     if ($urlArr[1] == "create") {
//         $controler->index();
//     } else
//         $controler->index();
// } else {
//     echo "no where to go";
// }