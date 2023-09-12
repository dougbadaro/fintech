<?php
class Autoloader {
    static public function loader($classname){
        $filename= "classes/" . str_replace("\\", '/',$classname) . ".class.php";
        if(file_exists($filename)){
            require_once($filename);
            if(class_exists($classname)){
                return true;
            }
        }
        return false;
        spl_autoload_extensions(".class.php");
        spl_autoload_register("Autoloader::loader");
    }

}