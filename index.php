<?php

/**/
require_once('templates/db_conf.php');
require_once('templates/functions.php');



//Добавляем задачу
if(!$errors){
    if(isset($_GET['addClick'])){
        $page_content = include_template('add.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
    }
//Показываем все задачи
    else {
        $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $requireds = ['name', 'project'];
    $title_tasks = $_POST['name'];
    $projects_id = $_POST['project'];
    $sql = "SELECT projects.id, title_project
            FROM projects
            WHERE title_project = '". $_POST['project'] . "'";
    $result = mysqli_query($dd_conf, $sql);
    if($result){
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($result as $res){
            $projects_id = $res['id'];
        }
    }
    if(is_date_valid($_POST['date'])){
        $dt_end = $_POST['date'];
    }else{
        $dt_end = "null";
    }
    $errors = [];
    foreach($requireds as $required){
        if(empty($_POST[$required])){
            $errors[$required] = 'error';
        }
    }
    if (count($errors)) {
        $page_content = include_template('add.php', ['errors' => $errors, 'projects' => $projects,'tasks' => $tasks]);
    }
    else {
        if(isset($_FILES['file'])){
            $file_name = $_FILES['file']['name'];
            if($file_name){
                $file_path = __DIR__ . '/uploads/';
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
            }else {
                $file_name = null;
            }
        }
        $sql = "INSERT INTO tasks (user_id, project_id, title_task, dt_end, dl_file) VALUES ( $user, $projects_id, '$title_tasks', '$dt_end' , '$file_name' )";
        $stmt = mysqli_prepare($dd_conf, $sql);
        $res = mysqli_stmt_execute($stmt);
        header("Location: index.php");
    }
}


$layout_content = include_template('layout.php', ['content' => $page_content, 'content' => $page_content, 'title' => 'Дела в порядке']);
print($layout_content);

?>

