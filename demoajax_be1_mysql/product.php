<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($class_name) {
    require './app/models/' . $class_name . '.php';
});

$pathURI = explode('-', $_SERVER['REQUEST_URI']);
$id = $pathURI[count($pathURI) - 1];

//$id = $_GET['id'];
$productModel = new ProductModel();
$comment = new Comments();

//Tang view
if (isset($_SESSION["view"]) ) {
    
    //Kiem tra id da ton tai trong mang
    if (!in_array($id, $_SESSION["view"])) {
        $_SESSION["view"][] = $id;

        //Goi ham tang view
        $productModel->updateView($id);
    }
}
else{
    $_SESSION["view"] = array();
    $_SESSION["view"][] = $id;

    //Goi ham tang view
    $productModel->updateView($id);
}

$item = $productModel->getProductById($id); 
//if(isset($_GET[]))
$listcomment = $comment->getCommentById($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q"crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php
                    $mainPhoto = explode(',', $item['product_photo']);    
                ?>
                
                <img src="../public/images/<?php echo $mainPhoto[0]; ?>" class="img-fluid" alt="...">
                
                <?php    
                    foreach ($mainPhoto as $photo) {
                ?>
                
                <img src="../public/images/<?php echo $photo; ?>" class="img-fluid" alt="..." style="width: 50px;">
                
                <?php 
                    }
                ?>
                <div class="rating rating-count">
                    <h1 class="count">5.0</h1>
                    <i class="fas fa-star" id="star_1" ></i>
                    <i class="fas fa-star" id="star_2" ></i>
                    <i class="fas fa-star" id="star_3" ></i>
                    <i class="fas fa-star" id="star_4" ></i>
                    <i class="fas fa-star" id="star_5" ></i>
                </div>
            </div>
            <div class="col-md-8">
                <h1><?php echo $item['product_name'] ?></h1>
                <p>Giá: <?php echo number_format($item['product_price']).' VND' ?></p>
                <p>
                    <?php echo $item['product_description'] ?>
                </p>
                <p>Lượt xem: <?php echo $item['product_view'] ?></p>
                <h4 class="my-4 border-bottom py-2">Viết đánh giá của bạn: </h4>
                
                <div class="form-comment-group">
                    <div id="comment_form">
                        <input type="hidden" name="id" id="product_id" value="<?php echo $item['id'] ?>">
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" name="name_comment" id="name_comment" class="form-name" placeholder="Enter Name" autocomplete="off">
                            </div>
                            <div class="col-md-5">
                                <div class="rating">
                                    <i class="fas fa-star star-rating" id="star_1" data-index="0" value="1"></i>
                                    <i class="fas fa-star star-rating" id="star_2" data-index="1" value="2"></i>
                                    <i class="fas fa-star star-rating" id="star_3" data-index="2" value="3"></i>
                                    <i class="fas fa-star star-rating" id="star_4" data-index="3" value="4"></i>
                                    <i class="fas fa-star star-rating" id="star_5" data-index="4" value="5"></i>
                                </div>
                            </div>
                        </div>
                        
                        <textarea name="comment" id="comment" cols="97" rows="7" placeholder="Enter your comment"></textarea><br>
                        <button id="submit" class="btn btn-info">Comments</button>
                </div>
                </div>
                <div class="result-comment">
                    <p class="title">Comments</p>
                    <div class="show-comment" id="show-comment">
                        <?php 
                            foreach($listcomment as $value){ 
                        ?>
                            <div class='show'>
                                <div class='show-name'>
                                    <p>By <b><?= $value['name_comment'] ?></b> on <i><?= $value['date_comment']?></i></p>
                                </div>
                                <div class='show-content'>
                                    <p> <?= $value['comment'] ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>    
            </div>
        </div>
        
    </div>
    <script src="../js/comment.js"></script>
    <script src="../js/rating.js"></script>
</body>
</html>