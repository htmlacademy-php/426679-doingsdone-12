<?php

/**/
require_once('templates/functions.php');


//Добавляем задачу
if (isset($_SESSION['user'])) {
    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
}
else {
    $page_content = include_template('guest.php',['errors' => $errors]);
}


layout($page_content,$userName);

?>

