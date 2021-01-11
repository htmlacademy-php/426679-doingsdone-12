<?php

/**/
require_once('templates/db_conf.php');
require_once('templates/functions.php');
$user = 4;



$sql = "SELECT id, title_project, projects.user_id FROM projects";
$result = mysqli_query($dd_conf, $sql);

if($result){
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sql = "SELECT title_task, user_id, project_id, dt_end FROM tasks WHERE tasks.user_id = " . $user;
$result = mysqli_query($dd_conf, $sql);
if($result){
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sort = filter_input(INPUT_GET, 'sort');
if($sort){
    $sql = "SELECT title_task, project_id, dt_end, tasks.user_id, projects.id FROM tasks
    JOIN projects WHERE tasks.user_id =" . $user ." && projects.id =" . $sort . " && project_id=" . $sort;
    $result = mysqli_query($dd_conf, $sql);

    $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(!$tasks_sort){
        http_response_code(404);
    }
}
else {
    $tasks_sort = $tasks;
}

$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
$add_task = include_template('add.php', ['projects' => $projects, 'tasks' => $tasks, 'sort' => $sort]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'content' => $add_task, 'title' => 'Дела в порядке']);
print($layout_content);

?>

