<?php

$dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
if ($dd_conf == false){
    print('Ошибка подключения: ' . mysqli_connect_error());
}
else {
    print("Соединение установлено");
}

$sql = "SELECT username, title_project FROM users, projects WHERE users.id = projects.id AND users.id = 1";
$result = mysqli_query($dd_conf, $sql);
require_once('templates/functions.php');
require_once('templates/data.php');

if($result){
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);
print($layout_content);

?>

