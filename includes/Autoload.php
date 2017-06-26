<?php
spl_autoload_register( function($name){
	if(file_exists("classes/$name.class.php")) {
        require_once("classes/$name.class.php");
    }
	else if(file_exists("includes/$name.class.php")) {
        require_once("includes/$name.class.php");
    }
    else if (strpos($name, '\\')) {
        $name = str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';
        if (file_exists($name)) {
            require_once($name);
        }
    }
});

