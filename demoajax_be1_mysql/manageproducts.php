<?php
require_once './config/database.php';
spl_autoload_register(function ($class_name) {
    require './app/models/' . $class_name . '.php';
});

$notification = '';
$productModel = new ProductModel();

if (isset($_POST['deleteProduct'])) {
    $id = $_POST['id'];
    if($productModel->deleteProduct($id)) {
        $notification = 'Deleted successfully';
    }
}

$productList = $productModel->getProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <div class="container">

        <!-- Xuất thông báo -->
        <?php
        if(!empty($notification)) {
        ?>
        <div class="alert alert-success" role="alert">
            <?php echo $notification; ?>
        </div>
        <?php
        }
        ?>

        <div class="row">
            <div class="col-6">
                <h1>Manage Products</h1>
            </div>
            <div class="col-6 text-right">
                <a href="createproduct.php" class="btn btn-primary">CREATE</a>
            </div>
        </div>
        
        <table class="table">
            <thead>
                <td>ID</td>
                <td style="width: 50px;">Product Photo</td>
                <td>Product Name</td>
                <td>Update</td>
                <td>Delete</td>
            </thead>
            <?php
            foreach ($productList as $item) {
            ?>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <?php
                    $mainPhoto = explode(',', $item['product_photo']);
                ?>

                <td><img src="./public/images/<?php echo $mainPhoto[0] ?>" class="img-fluid" alt="..."></td>
                <td><?php echo $item['product_name'] ?></td>
                <td><a href="updateproduct.php?id=<?php echo $item['id'] ?>" class="btn btn-primary">UPDATE</a></td>
                <td>
                    <form action="manageproducts.php" method="post" onsubmit="return confirm('Xoa khong?')">
                        <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                        <button type="submit" name="deleteProduct" class="btn btn-danger">DELETE</button>
                    </form>                
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>
</html>