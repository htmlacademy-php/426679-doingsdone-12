<?php
    require_once('templates/functions.php');

    $link = conect();
    $errors= [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $required = ['email', 'password', 'name'];

        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }
        }
        $email = mysqli_real_escape_string($link, $form['email']);

        if (empty($errors)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //Регистрация пользователя(проверка email на существование)
                $sql = "SELECT email FROM users WHERE email = '$email' ";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $errors['email'] = 'Email существует';
                } else {
                    $password = password_hash($form['password'], PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (dt_add, username, email, password) VALUES (NOW(), ?, ?, ?)";
                    $stmt = db_get_prepare_stmt($link, $sql, [$form['name'],$form['email'],$password]);
                    $result = mysqli_stmt_execute($stmt);
                }
                if ($result && empty($errors)) {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $errors['email'] = 'Проверьте написание Email';
            }
        }
    }

    register($errors, $form);
