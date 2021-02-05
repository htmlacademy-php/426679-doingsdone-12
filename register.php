<?php
    require_once('templates/functions.php');

    $link = conect();
    $errors= [];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $form = $_POST;
        $required = ['email', 'password'];

        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }           
        }
        $email = mysqli_real_escape_string($link, $form['email']);
        //Регистрация пользователя(проверка email на существование)
        if(userSearch($link, $email) == 'Email существует'){
            $errors['email'] = 'Email существует';
        }
    }

    register($errors,$form);
?>
