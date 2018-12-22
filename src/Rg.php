<?php namespace Cajudev\Validator;

use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Realiza a validação de RG's
 * 
 *  @author Richard Lopes
 */

class Rg {

    private const REGEX = '/^(?!(\d)\1{8})\d{9}|\d{8}[xX]$/';

    private $number;

    private function __construct($number) {
        $this->number = $number;
    }
    
    /**
     * validate
     *
     * @param  mixed $number
     *
     * @return Rg
     */

    public static function validate($number) {
        Cleaner::cleanNumber($number, "xX");
        $number = strtoupper($number);

        if(preg_match(self::REGEX, $number)) {
            if(self::getDigit($number) == $number[8]) {
                return new Rg($number);
            }
        }
        return false;
    }

    /**
     * validateArray
     *
     * @param  mixed $array
     * @param  mixed $pattern
     *
     * @return array
     */

    public static function validateArray($array) {
        $ret = array();
        foreach($array as $element) {
            if($number = self::validate($element)) {
                $ret[] = $number;
            }
        }
        return $ret;
    }
    
    private static function getDigit($num) {
        $sum = 0;

        for($i = 0, $j = 2; $i < 8; $i++, $j++) {
            $sum += $num[$i] * $j;
        }

        if($sum % 11 == 0) {
            return 0;
        }else if($sum % 11 == 1) {
            return 'X';
        }else {
            return 11 - $sum % 11;
        }
    }

    /**
     * getNumber
     *
     * @param  mixed $formatted
     *
     * @return string
     */

    public function getNumber($formatted = true) {
        return $formatted ? Masker::mask("##.###.###-#", $this->number) : $this->number;
    }
}