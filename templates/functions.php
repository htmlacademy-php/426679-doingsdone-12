<?php

$conection = conect();
$projects = project($conection);
$tasks = task($conection, user_db());
$tasks_sort = sort_task($conection, $tasks, user_db());

    //Подключаем базу
    function conect(){
        $dd_conf = mysqli_connect("localhost", "root", "root", "doingsdone");
        if ($dd_conf == false){
            print('Ошибка подключения: ' . mysqli_connect_error());
            return null;
        }
        return $dd_conf;
    }

    //Получаем все проекты
    function project($dd_conf){
        $sql = "SELECT id, title_project, projects.user_id FROM projects";
        $result = mysqli_query($dd_conf, $sql);
        if($result){
            return $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }

    //Получаем все задачи
    function task($dd_conf, $user){
        $sql = "SELECT title_task, user_id, project_id, dt_end, dl_file FROM tasks WHERE tasks.user_id = " . $user;
        $result = mysqli_query($dd_conf, $sql);
        if($result){
            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $tasks;
        }
        return null;
    }

//Заполняем список задач
    function sort_task($dd_conf, $tasks, $user){
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
            return $tasks_sort;
        }
        return $tasks_sort;
    }

    //Поиск файл и его открытие
    function include_template($name, $data){
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

    //Подсчет проектов
    function countElements(array $elements, array $values){
        $intElement = 0;
        print($values['id']);
            foreach($values as $value){
                if($value['project_id'] == $elements['user_id']){
                    $intElement++;
                }
            }
        return $intElement;
    };

    //Фильтр на символы
    function filterEsc($str){
        $text = htmlspecialchars($str);
        return $text;
    }

    //Считаем часы до завершения
    function date_complit($received_date) {
        $ts = time();
        $secs_in_day = 86400;
        $end_ts = strtotime($received_date);
        $hours = floor(($end_ts - $ts) / 3600);
        return $hours;
    };

    //Формируем ссылку
    function add_Link($value){
        $element = '?tab=' . $value['title_project'] . '&sort=' . $value['user_id'];
        return $element;
    }

    //Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
    function is_date_valid(string $date) : bool {
        $format_to_check = 'Y-m-d';
        $dateTimeObj = date_create_from_format($format_to_check, $date);

        return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
    }
    //Выводим страницу добавления задачи
    function addTaskPage($errors, $projects, $tasks){
        $page_content = include_template('addTask.php', ['errors' => $errors, 'projects' => $projects,'tasks' => $tasks]);
        layout($page_content);
    }

    //Выводим главную страницу
    function layout($page_content){
        $layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Дела в порядке']);
        print($layout_content);
    }

    function register($errors, $form){
        $page_content = include_template('addRegister.php', ['errors' => $errors, 'form' => $form ]);
        layout($page_content);
    }

    function userSearch($link, $email){
        $sql = "SELECT email FROM users WHERE email = '$email' ";
        $result = mysqli_query($link, $sql);
        if(!$result){
            return 'Email существует';
        }
        return 'Email не существует';

    }

    //Поиск юзера
    function user_db(){
        $user = 1;
        return $user;
    }

?>
