<?php

class Util
{

    public static function dateNow(){
        $dtz = new DateTimeZone("Asia/Hong_Kong"); //Your timezone
        $now = new DateTime(date("Y-m-d"), $dtz);
        return $now->format("Y-m-d H:i:s");
    }

    public static function redirect($url)
    {
        $to =  'https://' . $_SERVER['HTTP_HOST'] . '/' . $url;
        ob_start();
        header("location:$url");
        ob_flush();
    }

    public static function getParam($param){
        if(isset($_REQUEST[$param])){
            return $_REQUEST[$param];
        }else{
            return false;
        }
    }

    
    public static function date($date=null){
        if(!empty($date)){
            $formated = date('m/d/Y', strtotime($date));
        }else{
            $formated = date('m/d/Y');
        }
        return $formated;
    }

    public static function timeFormat($time)
    {
        $format = date('h:i A', strtotime($time));
        return $format;
    }

    public static function debug($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}
