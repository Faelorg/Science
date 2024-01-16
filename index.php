<?php
$sql = new mysqli("localhost", "root", "", "efremov_Science");

function Registration($login, $password){
    global $sql;
    if ($login != "") {
        if ($password != "") {
            $sql->query("INSERT INTO Users (`login`, `password`, `role`) VALUES ('$login', '$password', '1')");
        }
        else{
            echo http_response_code(401)." пароль не может быть пустым";
        }
    }
    else{
        echo http_response_code(401)." логин не может быть пустым";
    }

}

function Authorization($login, $password){
    global $sql;
    if ($login != "") {
        if ($password != "") {
            if ($user = $sql->query("SELECT * FROM `Users` WHERE `login` = '$login' and `password` = '$password'")) {
                $arr = [];

                foreach ($user as $row) {
                    $arr[] = $row;
                }


                return json_encode($arr, JSON_UNESCAPED_UNICODE);
            }
            else{
                echo http_response_code(401)." неверный логин или пароль";
            }
        }
        else{
            echo http_response_code(401)." пароль не может быть пустым";
        }
    }
    else{
        echo http_response_code(401)." логин не может быть пустым";
    }
}

echo Authorization('user1','1234');

function FindUserById(){

}

function GetPosts(){
    global $sql;
    if ($posts = $sql->query("SELECT * FROM Posts")) {    
        $arr = [];
        foreach ($posts as $post) {
            $arr[] = $post;
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}

function GetCommentsUser($idUser){
    global $sql;
    if ($comments = $sql->query("SELECT * FROM Commentary where id_user = '$idUser'")) {    
        $arr = [];
        foreach ($comments as $comment) {
            $arr[] = $comment;
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}

function GetCommentsPost($idPost){
    global $sql;
    if ($comments = $sql->query("SELECT * FROM Commentary where id_Posts = '$idPost'")) {    
        $arr = [];
        foreach ($comments as $comment) {
            $arr[] = $comment;
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}

?>