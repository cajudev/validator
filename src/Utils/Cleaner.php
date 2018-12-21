<?php namespace Cajudev\Validator\Utils;

/**
 *
 * Aplica máscara em números
 * 
 *  @author Richard Lopes
 */

class Cleaner {

    public static function cleanNumber(&$number) {
        $number = preg_replace("/[^0-9]/", "", $number);
    }
}

    