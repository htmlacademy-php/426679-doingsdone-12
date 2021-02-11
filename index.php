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

$search = $_GET['q'] ?? '';

if($search){
    $sql = "SELECT * FROM tasks " . "JOIN users ON tasks.user_id = users.id " .
    "WHERE MATCH(title_task) AGAINST(?)";
    $link = conect();
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
		mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
}


layout($page_content,$userName);

?>

