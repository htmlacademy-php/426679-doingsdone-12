<?php

/**/
require_once('templates/functions.php');

$conection = conect();
$projects = project($conection);
$tasks = task($conection, user_db());
$tasks_sort = sort_task($conection, $tasks, user_db());


//Добавляем задачу
if(!$errors){
if(isset($_GET['addClick'])){
    $page_content = include_template('addTask.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
}
//Показываем все задачи
else {
    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
}
}

$layout_content = include_template('layout.php', ['content' => $page_content, 'content' => $page_content, 'title' => 'Дела в порядке']);
print($layout_content);

?>

