<?php
class Session
{
    public static function exeists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function delete($name)
    {
        if (self::exeists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function flash($name,$string=''){
        if(self::exeists($name)){
            $session=self::get($name);
            self::delete($name);
            return $session;
        }
        else{
            self::put($name,$string);
        }
    }
}
