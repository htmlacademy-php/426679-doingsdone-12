<?php
//Подключаем базу
$dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
if ($dd_conf == false){
    print('Ошибка подключения: ' . mysqli_connect_error());
}

$user = 1;

//Получаем все проекты
$sql = "SELECT id, title_project, projects.user_id FROM projects";
$result = mysqli_query($dd_conf, $sql);

if($result){
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//Получаем все задачи
$sql = "SELECT title_task, user_id, project_id, dt_end, dl_file FROM tasks WHERE tasks.user_id = " . $user;
$result = mysqli_query($dd_conf, $sql);
if($result){
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//Заполняем список задач
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



?>
