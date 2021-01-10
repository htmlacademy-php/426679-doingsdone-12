<?php
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
?>
