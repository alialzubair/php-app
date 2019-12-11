<?php
class Redirct{
    public static function to($location){
        if($location){
            if(is_numeric($location)){
                switch($location){
                    case 404:
                    header('HTTP/1.0 404 Not Found');
                     include '404.php';
                     exit();

                    break;
                }
            }



            //redirct to some page
            header("location:{$location}");
            exit();
        }
    } 
}