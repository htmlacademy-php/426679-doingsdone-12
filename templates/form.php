<?php
    require_once 'functions.php';
    require_once 'db_conf.php';

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $requireds = ['name', 'project'];
                $errors = [];
            }

            foreach($requireds as $required){
                if(empty($_POST[$required])){
                    $errors[$required] = 'error';
                }
            }

            if (count($errors)) {
                $page_content = include_template('add.php', ['errors' => $errors, 'projects' => $projects,'tasks' => $tasks]);
            }
            else {

            }

    print($page_content);
?>
