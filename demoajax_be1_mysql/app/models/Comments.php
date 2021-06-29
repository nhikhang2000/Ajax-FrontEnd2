<?php
class Comments extends Db{

    //Them comment vao database
    public function AddComment($comments, $product_id, $name_comment)
    {
        $sql = parent::$connection->prepare("INSERT INTO `comments` (`comment`, `product_id`,`name_comment`) VALUES (?, ?, ?)");
        $sql->bind_param('sis', $comments, $product_id,$name_comment);
        return $sql->execute();
    }

    // Lấy tát cả comment
    public function getCommentById($id)
    {
            //2. Viết câu SQL
            $sql = parent::$connection->prepare("SELECT * FROM products, comments WHERE 
            products.id = comments.product_id AND comments.product_id = ?");
            $sql->bind_param('i', $id);
            return parent::select($sql);
    }

}