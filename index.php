<?php

/**/
require_once('templates/functions.php');
$link = conect();
$show_completed = (int) $_GET['show_completed'];
//Поиск задачи


if (isset($_GET['show_completed'])) {
    $show_complete_tasks = filter_input(INPUT_GET, 'show_completed', FILTER_VALIDATE_INT);
    $_SESSION['show_complete_tasks'] = $show_complete_tasks;
};

if (empty($_GET['show_tasks'])) {
    $tasks_completed = filter_input(INPUT_GET, 'check', FILTER_VALIDATE_INT);
    $task_id = filter_input(INPUT_GET, 'task_id', FILTER_VALIDATE_INT);
    $_SESSION['tasks'] = $tasks_completed;
    $_SESSION['task_id'] = $task_id;
};

if(empty($_GET['tasks_id'])){
    $task_id = filter_input(INPUT_GET, 'task_id', FILTER_VALIDATE_INT);
    foreach ($tasks as $value){
        if($value['id']== $task_id){
            $task_title = $value['title_task'];
        }
    }
    mysqli_query($link, "START TRANSACTION");
    $t1 = mysqli_query($link,"UPDATE tasks SET st_check = st_check + 1 WHERE id = " . $task_id);
    $t2 = mysqli_query($link, "INSERT INTO tasks (st_check, title_task) VALUES ({$_SESSION['tasks']}, '$task_title')");
    if($t1 && $t2){
        mysqli_query($link, "COMMIT");
    }
    else {
        mysqli_query($link, "ROLLBACK");
    }
    
}


$search = $_GET['q'] ?? '';

if($search){
    $sql = "SELECT user_id, title_task, project_id, dt_end, dl_file FROM tasks " .
    "JOIN users ON tasks.user_id = users.id " .
    "WHERE MATCH(title_task) AGAINST(?)";
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
		mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(!empty($result)){
        $tasks_sort = [];
        foreach($result as $res){
            if($res['user_id']== $user_id){
                $tasks_sort[] = $res;
            }
        }
    }else {
        $tasks_sort = [];
    }
}

//Добавляем задачу
if (isset($_SESSION['user'])) {
    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks]);
}
else {
    $page_content = include_template('guest.php',['errors' => $errors]);
}



layout($page_content,$userName);

?>

