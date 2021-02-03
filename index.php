<?php

/**/
require_once('templates/functions.php');




//Добавляем задачу

$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);


layout($page_content);

?>

