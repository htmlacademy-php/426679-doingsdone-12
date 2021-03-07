<?php
ini_set('display_errors', 'On');
error_reporting(32767);
session_start();
$userName = null;
$user_id = null;
$conection = conect();

if (isset($_SESSION['user'])) {
    $user_id = user_db($_SESSION['user']);
    $userName = user_name($_SESSION['user']);
    $projects = project($conection, $user_id);
    $tasks = task($conection, $user_id);
    $tasks_sort = sort_task($conection, $tasks, $user_id);
}

/**
 * Подключаем базу
 *
 * @return mysqli Ресурс соединения
 */
function conect()
{
    $dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
    if ($dd_conf == false) {
        print('Ошибка подключения: ' . mysqli_connect_error());
        return null;
    }
    return $dd_conf;
}

/**
 * Получаем все проекты
 * у авторизованного пользователя
 * @param string $dd_conf База данных
 * @param integer $user_id ID пользователя
 *
 * @return string $projects Возвращаем все проеты
 */
function project($dd_conf, $user_id)
{
    $sql = "SELECT id, title_project, projects.user_id FROM projects WHERE user_id = " . $user_id;
    $result = mysqli_query($dd_conf, $sql);
    if ($result) {
        return $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

/**
 * Получаем все задачи
 * у авторизованного пользователя
 * @param string $dd_conf База данных
 * @param integer $user_id ID пользователя
 *
 * @return array $tasks Возвращаем все задачи
 * @return null Пустые записи
 */
function task($dd_conf, $user_id)
{
    $sql = "SELECT * FROM tasks WHERE tasks.user_id = " . $user_id;
    $result = mysqli_query($dd_conf, $sql);
    if ($result) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $tasks;
    }
    return null;
}

/**
 * Выполняем сортировку всех записей
 * авторизованных пользователей
 * @param string $dd_conf База данных
 * @param string $tasks Все записи задач
 * @param integer $user_id ID пользователя
 *
 * @return array $tasks_sort Возвращаем отсортированные задачи
 */
function sort_task($dd_conf, $tasks, $user_id)
{
    $sort = filter_input(INPUT_GET, 'sort');
    if ($sort) {
        $sql = "SELECT * FROM tasks
                JOIN projects WHERE tasks.user_id =" . $user_id . " && projects.id =" . $sort . " && project_id=" . $sort;
        $result = mysqli_query($dd_conf, $sql);
        $tasks_sort = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (!$tasks_sort) {
            http_response_code(404);
        }
    } else {
        $tasks_sort = $tasks;
        return $tasks_sort;
    }
    return $tasks_sort;
}

/**
 * Поиск файл и его открытие
 * @param string $name имя файла
 * @param array $data Массив с параметрами
 *
 * @return string $result Возвращаем страницу
 */
function include_template($name, $data)
{
    $name = __DIR__ . '/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();
    return $result;
}

/**
 * Подсчет проектов
 * @param array $elements Массив с параметрами пользователя
 * @param array $values Массив с проектами
 *
 * @return integer $intElement Возвращаем число задач
 */
function countElements(array $elements, array $values)
{
    $intElement = 0;
    foreach ($values as $value) {
        if ($value['project_id'] == $elements['id']) {
            $intElement++;
        }
    }
    return $intElement;
};
/**
 * Фильтр на символы
 * @param string $str Строка без очистки от сисмволов
 *
 * @return string $text Возвращаем очищенную строку
 */
function filterEsc($str)
{
    $text = htmlspecialchars($str);
    return $text;
}

/**
 * Считаем время до завершения
 * @param string $received_date Строка с датой
 *
 * @return float $day Возвращаем дни
 */
function date_complit($received_date)
{
    $ts = time();
    $secs_in_day = 86400;
    $end_ts = strtotime($received_date);
    $day = floor(($end_ts - $ts) / 3600);
    return $day;
};

/**
 * Формируем ссылку
 * @param array $value Массив с данными о пользовате
 *
 * @return string $element Возвращаем готовую ссылку
 */
function add_Link($value)
{
    $element = '?tab=' . $value['title_project'] . '&sort=' . $value['id'];
    return $element;
}

/**
 * Проверяет переданную дату
 * на соответствие формату 'ГГГГ-ММ-ДД'
 * @param string $date Массив с данными о пользовате
 *
 * @return string $element Возвращаем готовую ссылку
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);
    $today = date_create_from_format($format_to_check, date('Y-m-d'));
    if ($dateTimeObj >= $today) {
        return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
    }
    return false;
}

/**
 * Собираем страница добавления задачи
 *
 * @param array $errors Массив с ошибками
 * @param array $projects Массив с проектами
 * @param array $tasks Массив с задачами
 *
 */
function addTaskPage($errors, $projects, $tasks)
{
    $page_content = include_template('addTask.php', ['errors' => $errors, 'projects' => $projects, 'tasks' => $tasks]);
    layout($page_content, $_SESSION['user']);
}

/**
 * Собираем страница с добавлением проектов
 *
 * @param array $errors Массив с ошибками
 * @param array $projects Массив с проектами
 * @param array $tasks Массив с задачами
 *
 */
function addProjectPage($errors, $projects, $tasks)
{
    $page_content = include_template('addProject.php', ['errors' => $errors, 'projects' => $projects, 'tasks' => $tasks]);
    layout($page_content, $_SESSION['user']);
}

/**
 * Выводим главную страницу
 *
 * @param array $page_content Собранная страница
 *
 */
function layout($page_content)
{
    $userName = null;
    if (isset($_SESSION['user'])) {
        $userName = $_SESSION['user'];
    }
    $layout_content = include_template('layout.php', ['userName' => $userName, 'content' => $page_content, 'title' => 'Дела в порядке']);
    print($layout_content);
}

/**
 * Собираем страницу регистрации
 *
 * @param array $errors Массив с ошибками
 * @param array $form Массив с данными из формы регистрации
 *
 */
function register($errors, $form)
{
    $userName = null;
    if (isset($_SESSION['user'])) {
        $userName = $_SESSION['user'];
    }
    $page_content = include_template('addRegister.php', ['errors' => $errors, 'form' => $form]);
    layout($page_content, $userName);
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}


/**
 * Собираем страницу авторизации
 *
 * @param array $errors Массив с ошибками
 *
 */
function auth($errors)
{
    $page_content = include_template('auth.php', ['errors' => $errors, 'title' => 'Дела в порядке']);
    layout($page_content);
}

/**
 * Поиск id пользователя
 *
 * @param array $users Массив с информацией о пользователе
 *
 * @return string Возвращаем ID пользовотеля
 */
function user_db($users)
{
    $user_id = $users['id'];
    return $user_id;
}

/**
 * Поиск имени пользователя
 *
 * @param array $users Массив с информацией о пользователе
 *
 * @return string Возвращаем имя пользовотеля
 */
function user_name($users)
{
    $userName = $users['username'];
    return $userName;
}
