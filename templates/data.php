<?php

$dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
if ($dd_conf == false){
    print('Ошибка подключения: ' . mysqli_connect_error());
}

$sql = "SELECT title_project, projects.user_id FROM projects";
$result = mysqli_query($dd_conf, $sql);

if($result){
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sql = "SELECT title_task, user_id, project_id, dt_end FROM tasks WHERE tasks.user_id = 4";
$result = mysqli_query($dd_conf, $sql);
if($result){
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
