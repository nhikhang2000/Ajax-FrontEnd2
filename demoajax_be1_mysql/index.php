<?php
require_once './config/database.php';
spl_autoload_register(function ($class_name) {
    require './app/models/' . $class_name . '.php';
});

$productModel = new ProductModel();

$totalRow = $productModel->getTotalRow();
$perPage = 3;
$page = 1;
if(isset($_GET['page'])) {
    $page = $_GET['page'];
}
//$page = isset($_GET['page']) ? $_GET['page'] : 1;

$productList = $productModel->getProductsByPage($perPage, $page);

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getCategories();

$pageLinks = Pagination::createPageLinks($totalRow, $perPage, $page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q"crossorigin="anonymous"/>
 <!-- Jquery-->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light">
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <?php
                foreach ($categoryList as $item) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="category.php?id=<?php echo $item['id']; ?>"><?php echo $item['category_name']; ?></a>
                </li>
                <?php
                }
                ?>
                
            </ul>
            <div class="form-search mr-auto">
                <form class="form-inline my-2 my-lg-0" style="display: flex;" action="search.php" method="get">
                    <input class="form-control" style="width: 80%;" type="text" placeholder="Search" name="key" id="search" autocomplete="off">
                    <input class="btn btn-info rounded-0" style="margin-left:10px; border-radius: 5px;" value="Search"  type="submit">
                </form>
                <div class="list-group" id="show-list">

                </div>
            </div>
           
        </div>
    </nav>


    <div class="container" style="margin-top: 35px;">
        <div class="row">
            <div class="col-md-2">
                <h2 class='note'>Danh muc</h2>
                <ul class="navbar-nav">
                    <?php
                        foreach ($categoryList as $item) {
                    ?>
                        <li class="nav-item" style="display:flex;">
                            <input style="margin-top: 7px;margin-right: 10px;" value="<?php echo $item['id']?>" type="checkbox" name="category-check" onchange="">
                            <label><?= $item['category_name']; ?></label>
                        </li>
                    <?php
                    }
                    ?> 
                </ul>
            </div>
            <div class="col-md-10">
                <div class="row products-list">
                    <?php
                    foreach ($productList as $item) {
                    ?>
                    <div class="col-md-4 ">
                        <div class="card">
                            <?php
                            $productPath = strtolower(str_replace(' ', '-', $item['product_name'])) . '-' . $item['id'];
                            ?>
                            <a href="product.php/<?php echo $productPath; ?> " class="a-img">
                                <img src="./public/images/<?php echo $item['product_photo'] ?>" class="card-img-top" alt="...">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title" onclick="getProduct(<?php echo $item['id'] ?>)"><?php echo $item['product_name'] ?></h5>
                                <div class="" style="font-size: 13px;">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="row price-media">
                                    <div class="col-md-7">
                                    
                                        <p class="card-text"><?php echo number_format($item['product_price']).' VND' ?></p>
                                    </div>
                                    <div class="col-md-5">
                                       <div class="interactive">
                                            <a class="cmt" href="product.php/<?php echo $productPath; ?>"><i class="far fa-comment-dots" onclick="getProduct(<?php echo $item['id'] ?>)"></i></a>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                <!-- <?php echo $pageLinks; ?> -->
                
            </div>
            <div class="spinner-border" style="margin: 25px 450px; visibility: hidden;" role="status">
            </div>
            <button style="left: 0;bottom: -65px;" class="load-more btn my-5 btn-outline-info" >Load more</button>
        </div>
    </div>
        

<!-- Modal -->
        <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">               
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>

    <script src="js/script.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>