<?php

/**/
require_once('templates/functions.php');
$link = conect();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$show_complete_tasks = 0;
$show_completed = null;
$sort = null;
$errors = null;

if (isset($_GET['show_completed'])) {
    $show_completed = (int) $_GET['show_completed'];
    $show_complete_tasks = filter_input(INPUT_GET, 'show_completed', FILTER_VALIDATE_INT);
    $_SESSION['show_complete_tasks'] = $show_complete_tasks;
}

if (isset($_GET['check'])) {
    $tasks_completed = filter_input(INPUT_GET, 'check', FILTER_VALIDATE_INT);
    $task_id = filter_input(INPUT_GET, 'task_id', FILTER_VALIDATE_INT);
    $_SESSION['tasks'] = $tasks_completed;
    $_SESSION['task_id'] = $task_id;
};

if (isset($_GET['task_id'])) {
    $task_id = filter_input(INPUT_GET, 'task_id', FILTER_VALIDATE_INT);
    foreach ($tasks as $value) {
        if ($value['id']== $task_id) {
            $task_title = $value['title_task'];
        }
    }
    mysqli_query($link, "START TRANSACTION");
    $sql = "UPDATE tasks SET st_check = " . $_SESSION['tasks'] . " WHERE id = " . $task_id;
    $t1 = mysqli_query($link, $sql);
    if ($t1) {
        mysqli_query($link, "COMMIT");
    } else {
        mysqli_query($link, "ROLLBACK");
    }
    header("Location: index.php");
}


//Поиск задачи
$search = $_GET['q'] ?? '';

if ($search) {
    $sql = "SELECT user_id, title_task, project_id, dt_end, dl_file FROM tasks " .
    "JOIN users ON tasks.user_id = users.id " .
    "WHERE MATCH(title_task) AGAINST(?)";
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!empty($result)) {
        $tasks_sort = [];
        foreach ($result as $res) {
            if ($res['user_id']== $user_id) {
                $tasks_sort[] = $res;
            }
        }
    } else {
        $tasks_sort = [];
    }
}

//Сортировка даты
$sort_date = filter_input(INPUT_GET, 'sort_date');
if ($sort_date == "Повестка дня") {
    $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " && DATE(dt_end)=CURRENT_DATE()";
    $result = mysqli_query($link, $sql);
    $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
} elseif ($sort_date == "Завтра") {
    $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " && dt_end = DATE_SUB(CURRENT_DATE(), INTERVAL -1 DAY)";
    $result = mysqli_query($link, $sql);
    $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
} elseif ($sort_date == "Просроченные") {
    $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " && dt_end < CURRENT_DATE()";
    $result = mysqli_query($link, $sql);
    $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $sort_date = "Все задачи";
}

//Добавляем задачу
if (isset($_SESSION['user'])) {
    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks, 'tasks_sort' => $tasks_sort, 'sort' => $sort, 'show_complete_tasks' => $show_complete_tasks, 'sort_date' => $sort_date]);
} else {
    $page_content = include_template('guest.php', ['errors' => $errors]);
}

layout($page_content);

?>

