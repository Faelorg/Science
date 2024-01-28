<?php
session_start();

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


$sql = new mysqli("localhost", "root", "", "Science");

function GetUserById($id){
    global $sql;
    if ($result = $sql->query("SELECT * From User where id = '$id'")) {
        return json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    }
}

function GetNameUserById($id){
    global $sql;
    if ($result = $sql->query("SELECT * From User where id = '$id'")) {
        return json_encode($result->fetch_assoc()['Login'], JSON_UNESCAPED_UNICODE);
    }
}

function Registration($login, $password){
    global $sql;
    session_start();
    if (empty($sql->query("SELECT * FROM User where `Login` = '$login'")->fetch_assoc())) {
        $sql->query("INSERT INTO `User` (`Login`, `Password`, `Role`) VALUES ('$login', '$password', '0')");
        if ($result = $sql->query("SELECT * FROM User where `Login` = '$login' and `Password` = '$password'")) {
            $_SESSION["auth"] = true;
            $user = $result->fetch_assoc();
            $_SESSION["role"] = $user["Role"];
            $_SESSION['id'] = $user['id'];
        }
    }
    else{
        return json_encode(['code'=>'401', 'text'=>'Пользователь с таким именем уже зарегистрирован'], JSON_UNESCAPED_UNICODE);
    }
}

function Authorization($login, $password){
    global $sql;
    session_start();
    if ($result = $sql->query("SELECT * FROM User where `Login` = '$login' and `Password` = '$password'")) {
        $_SESSION["auth"] = true;
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION["role"] = $user["Role"];
    }
}

function Logout(){
    session_destroy();
}

function GetAuthorizationUser(){
    if ( isset($_SESSION["auth"])) {
        return json_encode(GetUserById($_SESSION['id']));
    }
    else{
        return '0';
    }
}

if (isset($_POST['session'])) {
    echo json_encode(getSession());
    session_regenerate_id();
    exit();
}

if (isset($_POST["logout"])) {
    Logout();
}

if (isset($_POST["login"], $_POST["password"], $_POST["auth"])) {
    echo Authorization($_POST["login"], $_POST["password"]);
    session_regenerate_id();
    exit();
}

if (isset($_POST["login"], $_POST["password"], $_POST["reg"])) {
    echo Registration($_POST["login"], $_POST["password"]);
    session_regenerate_id();
    exit();
}

if (isset($_POST["id"])) {
    echo GetNameUserById($_POST["id"]);
}

if (isset($_POST['authUser'])) {
    echo GetAuthorizationUser();
}

if (isset($_POST['logout'])) {
    Logout();
}

?>