<?php
    require_once('templates/functions.php');

    $link = conect();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = userSearch($link, $email);
    }

    register();
?>