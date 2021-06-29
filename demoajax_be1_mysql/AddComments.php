<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($class_name) { 
    require './app/models/' . $class_name . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);
$comment = $input['comment'];
$id = $input['id'];
$name_comment = $input['name_comment'];

$listcomment = new Comments();
$item = $listcomment->AddComment($comment,$id,$name_comment);

echo json_encode($item);
