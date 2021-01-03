<?php

/**/

require_once('templates/functions.php');

$dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
if ($dd_conf == false){
    print('Ошибка подключения: ' . mysqli_connect_error());
}

$sql = "SELECT id, title_project, projects.user_id FROM projects";
$result = mysqli_query($dd_conf, $sql);

if($result){
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sql = "SELECT title_task, user_id, project_id, dt_end FROM tasks WHERE tasks.user_id = 3";
$result = mysqli_query($dd_conf, $sql);
if($result){
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sort = filter_input(INPUT_GET, 'sort');
if($sort){
    $sql = "SELECT title_task, user_id, project_id, dt_end FROM projects, tasks WHERE tasks.user_id = 3 && projects.id ="  . $sort;
    $result = mysqli_query($dd_conf, $sql);
    $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
else {
    $tasks_sort = $tasks;
}



$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);
print($layout_content);

?>

