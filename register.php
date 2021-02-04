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
            if($field == 'email') {
                //Проверка email на существование
                $errors['email'] = userSearch($link, $form[$field]);
            }
        }


    }

    register($errors,$form);
?>
