<?php

/**
 *Страница добавления записи
 *
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('templates/functions.php');
$link = conect();
$errors = [];
$result = null;
if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form = $_POST;
        $requireds = ['name', 'project'];
        if (!isset($form['project'])) {
            $errors['project'] = 'error';
        } else {
            $projects_id = $_POST['project'];
        }
        $title_tasks = $_POST['name'];

        if (isset($projects_id)) {
            $sql = "SELECT projects.id, title_project
            FROM projects
            WHERE title_project = '" . $_POST['project'] . "'";
        }
        if (isset($sql)) {
            $result = mysqli_query($link, $sql);
        }
        if ($result) {
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($result as $res) {
                $projects_id = (int)$res['id'];
            }
        }
        if (is_date_valid($_POST['date'])) {
            $dt_end = $_POST['date'];
        } else {
            $errors['date'] = 'error';
        }

        foreach ($requireds as $required) {
            if (empty($_POST[$required])) {
                $errors[$required] = 'error';
            }
        }
        if (count($errors)) {
            addTaskPage($errors, $projects, $tasks);
        } else {
            if (isset($_FILES['file'])) {
                $file_name = $_FILES['file']['name'];
                if ($file_name) {
                    $file_path = __DIR__ . '/uploads/';
                    move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
                } else {
                    $file_name = null;
                }
            }
            $sql = "INSERT INTO tasks (user_id, dt_task, project_id, title_task, dt_end, dl_file) VALUES (?, NOW(), ?, ?, ?, ?)";
            $stmt = db_get_prepare_stmt($link, $sql, [$user_id, $projects_id, $form['name'], $form['date'], $file_name]);
            $res = mysqli_stmt_execute($stmt);
            header("Location: index.php");
        }
    } else {
        addTaskPage($errors, $projects, $tasks);
    }
} else {
    header("Location: index.php");
}
