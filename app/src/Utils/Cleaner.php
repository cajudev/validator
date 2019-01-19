<?php namespace Cajudev\Validator\Utils;

/**
 *
 * Remove caracteres especiais
 * 
 *  @author Richard Lopes
 */

class Cleaner {

    public static function cleanNumber(&$number, $exceptions = '') {
        $regex  = "/[^0-9";

        //Escapes special characters
        foreach(str_split($exceptions) as $exception){
            $regex .= $exception == "/" || $exception == "\\" ? "\\" . $exception : $exception;
        }

        $regex .= "]/";

        $number = preg_replace($regex, "", $number);
    }
}

    