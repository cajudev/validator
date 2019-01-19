<?php namespace Cajudev\Validator\Utils;

/**
 *
 * Aplica máscara em números
 * 
 *  @author Richard Lopes
 */

class Masker {

    public static function mask($mask, $string) {
        $ret = '';

        for($i = 0, $j = 0; $i <= strlen($mask) - 1; $i++) {
            $ret .= $mask[$i] == '#' ? $string[$j++] : $mask[$i];
        }

        return $ret;
    }
}