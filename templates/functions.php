<?php
    function include_template($name, $project){
        $name = 'templates/' . $name;
        $result = '';

        
        ob_start();
        extract($project);
        require $name;

        $result = ob_get_clean();
        return $result;
    }
?>
