<?php

class Input
{
    /**
     * this function  check the type of method
     */
    public static function exeist($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;

                break;
            case 'get':
                return (!empty($_POST)) ? true : false;

                break;

            default:
                return false;
                break;
        }
    }

    //make the method get to get the value of requst
    public static function get($item){
        // check  the item is exist
        if(isset($_POST[$item])){
            return $_POST[$item];
        }
        elseif(isset($_GET[$item])){
            return $_GET[$item];
        }
        else{
            return '';
        }
    }
}
