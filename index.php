<?php

require_once('templates/functions.php');
require_once('templates/data.php');

// показывать или нет выполненные задачи

    function countElements(array $elements, $value){
        $intElement = 0;
        foreach($elements as $element){
            if($element['category'] == $value){
                $intElement++;
            }
        };
        return $intElement;
    };


    $page_content = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks]);
    $layout_content = include_template('layout.php', ['content', $page_content, 'title' => 'Дела в порядке']);
    print($layout_content);

?>

