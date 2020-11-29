<?php
    function include_template($name, $project, $task){
        $name = 'templates/' . $name;
        $result = '';

        if (!file_exists($name)) {
            return $result;
        }
        ob_start();
        extract($project);
        require $name;

        $result = ob_get_clean();
        return $result;
    }
?>
