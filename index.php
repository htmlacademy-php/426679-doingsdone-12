<?php

/**/
require_once('templates/db_conf.php');
require_once('templates/functions.php');



            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $requireds = ['name', 'project'];
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

        }
    }


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
$layout_content = include_template('layout.php', ['content' => $page_content, 'content' => $page_content, 'title' => 'Дела в порядке']);
print($layout_content);

?>

