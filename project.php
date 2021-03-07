<?php
    /**
    *Формирование страницы с проектами
    *
    */
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    require_once('templates/functions.php');
    $link = conect();
    $errors = [];

    if (isset($_SESSION['user'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $form = $_POST;
            $required = ['name'];

            foreach ($required as $field) {
                if (empty($form[$field])) {
                    $errors[$field] = 'Это поле надо заполнить';
                }
            }

            if (empty($errors)) {
                $sql = "SELECT user_id, title_project FROM projects WHERE title_project = '" . $_POST['name'] ."'";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($result as $res) {
                        if ($res['title_project'] == $form['name'] && $res['user_id'] == $user_id) {
                            $errors[$field] = 'Проект существует';
                        }
                    }
                    if (empty($errors)) {
                        $sql = "INSERT INTO projects (user_id, title_project) VALUES (?,?)";
                        $stmt = db_get_prepare_stmt($link, $sql, [$user_id, $_POST['name']]);
                        $result = mysqli_stmt_execute($stmt);
                        if ($result && empty($errors)) {
                            header("Location: index.php");
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        header("Location: index.php");
    }


    addProjectPage($errors, $projects, $tasks)
?>



