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
?>
