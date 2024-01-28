<?php
session_set_cookie_params(7200,'http://localhost/Science/client/',false, false);
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}


session_start();
$sql = new mysqli("localhost", "root", "", "Science");

function CreatePost($name, $text){
    global $sql;

    $sql->query("INSERT INTO (`Name`,`Text`) values ('$name', '$text')");
}

function UpdatePost($id, $name, $text){
    global $sql;
    $sql->query("UPDATE `Post` set `Name` = '$name', `Text` = '$text' where `id`='$id'");
}

function DeletePost($id){
    global $sql;

    $sql->query("DELETE FROM `Post` WHERE `id` = '$id'");    
}

function GetPosts(){
    global $sql;
    if($result = $sql->query("SELECT * FROM `Post`")){
        $res = [];
        foreach ($result as $row) {
            $res[] = $row;
        }
        return json_encode($res,  JSON_UNESCAPED_UNICODE);
    }
}

function GetPostById($id){
    global $sql;
    if($result = $sql->query("SELECT * FROM `Post` where `id` = '$id'")){
        return json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    }
}

function verifyFunction($id){
    global $sql;
    $sql->query("UPDATE `Post` set `Status` = '1' where `id`='$id'");
}

if (isset($_POST["id"])) {
    echo GetNameUserById($_POST["id"]);
}


if (isset($_SESSION['role'])) {
    if ($_SESSION['role']==1) {
        
        if (isset($_POST['name'], $_POST['text'])) {
            if (isset($_GET['create'])) {
                CreatePost($_POST['name'], $_POST['text']);
            }
            if (isset($_GET['put']) && isset($_POST['id'])) {
                UpdatePost($_POST['id'],$_POST['name'], $_POST['text']);
            }
        }
        
        if (isset($_POST['id']) && isset($_POST['del'])) {
            DeletePost($_POST['id']);
        }

        if (isset($_POST['id']) && isset($_POST['ver'])) {
            verifyFunction($_POST['id']);
        }

    }
}

if (isset($_POST['id'])) {
    echo GetPostById($_GET['id']);
}

if (isset($_POST['all'])) {
    echo GetPosts();
}
?>