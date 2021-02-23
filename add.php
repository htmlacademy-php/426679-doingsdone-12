<?php

require_once('templates/functions.php');
$link = conect();
$errors = [];

if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $form = $_POST;
        $requireds = ['name', 'project'];
        $title_tasks = $_POST['name'];
        $projects_id = $_POST['project'];
        $sql = "SELECT projects.id, title_project
            FROM projects
            WHERE title_project = '". $_POST['project'] . "'";
        $result = mysqli_query($link, $sql);
        if($result){
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($result as $res){
                $projects_id = (int)$res['id'];
            }
        }
        if(is_date_valid($_POST['date'])){
            $dt_end = $_POST['date'];
        }
        else{
            $errors['date'] = 'error';
        }

        foreach($requireds as $required){
            if(empty($_POST[$required])){
                $errors[$required] = 'error';
            }
        }
        if (count($errors)) {
            addTaskPage($errors, $projects, $tasks);
        }
        else {
            if(isset($_FILES['file'])){
                $file_name = $_FILES['file']['name'];
                if($file_name){
                    $file_path = __DIR__ . '/uploads/';
                    move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
                }
                else {
                    $file_name = NULL;
                }
            }
            $sql = "INSERT INTO tasks (user_id, dt_task, project_id, title_task, dt_end, dl_file) VALUES (?, NOW(), ?, ?, ?, ?)";
            $stmt = db_get_prepare_stmt($link,$sql,[$user_id, $projects_id, $form['name'],$form['date'],$file_name]);
            $res = mysqli_stmt_execute($stmt);
            header("Location: index.php");
        }
    }
    else {
        addTaskPage($errors, $projects, $tasks);
    }
}
else {
    header("Location: index.php");
}
?>
