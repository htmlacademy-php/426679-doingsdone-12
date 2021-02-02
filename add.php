<?php

$link = conect();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            $projects_id = $res['id'];
        }
    }
    if(is_date_valid($_POST['date'])){
        $dt_end = $_POST['date'];
    }else{
        $dt_end = "NULL";
    }
    $errors = [];
    foreach($requireds as $required){
        if(empty($_POST[$required])){
            $errors[$required] = 'error';
        }
    }
    if (count($errors)) {
        $page_content = include_template('addTask.php', ['errors' => $errors, 'projects' => $projects,'tasks' => $tasks]);
    }
    else {
        if(isset($_FILES['file'])){
            $file_name = $_FILES['file']['name'];
            if($file_name){
                $file_path = __DIR__ . '/uploads/';
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
            }else {
                $file_name = NULL;
            }
        }
        $sql = "INSERT INTO tasks (user_id, project_id, title_task, dt_end, dl_file) VALUES ( ". user_db() .", $projects_id, '$title_tasks', $dt_end , '$file_name' )";
        $stmt = mysqli_prepare($link, $sql);
        $res = mysqli_stmt_execute($stmt);
        header("Location: index.php");
    }
}
?>