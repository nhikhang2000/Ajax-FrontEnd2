<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($class_name) {
    require './app/models/' . $class_name . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);
$arrcategoryId = $input['checkedCategories'];

$categoryModel = new ProductModel();
if(count($arrcategoryId) == 0){
   
    $item = $categoryModel->getProducts();
}
else{
    $item = $categoryModel->getProductsByNCategories($arrcategoryId);
}


echo json_encode($item);