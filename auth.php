<?php
    require_once('templates/functions.php');
    $link = conect();
    $errors= [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $required = ['email', 'password'];

        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }
        }
        $email = mysqli_real_escape_string($link, $form['email']);

        if (empty($errors)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($link, $sql);

                $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
                if ($user) {
                    if (password_verify($form['password'], $user['password'])) {
                        $_SESSION['user'] = $user;
                        header("Location: index.php");
                        exit();
                    }
                }
            } else {
                $errors['email'] = 'Проверьте написание Email';
            }
        }
    }
    auth($errors);
