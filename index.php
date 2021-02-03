<?php

/**/
require_once('templates/functions.php');

$conection = conect();
$projects = project($conection);
$tasks = task($conection, user_db());
$tasks_sort = sort_task($conection, $tasks, user_db());



//Добавляем задачу

$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);


layout($page_content);

?>

