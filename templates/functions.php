<?php
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

    function countElements(array $elements, $value){
        $intElement = 0;
        foreach($elements as $element){
            if($element['category'] == $value){
                $intElement++;
            }
        };
        return $intElement;
    };

    function filterEsc($str){
        $text = htmlspecialchars($str);
        return $text;
    }

    function date_complit($received_date) {
        $ts = time();
        $secs_in_day = 86400;
        $end_ts = strtotime($received_date);
        $hours = floor(($end_ts - $ts) / 3600);
        return $hours;
    };
?>
