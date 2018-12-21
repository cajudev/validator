<?php namespace Cajudev\Validator;

use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Realiza a validação de CNPJ's
 * 
 *  @author Richard Lopes
 */

class Cnpj {

    private const REGEX = '/^(?!(\d)\1{13})\d{14}$/';

    private $number;

    private function __construct($number) {
        $this->number = $number;
    }
    
    /**
     * validate
     *
     * @param  mixed $number
     *
     * @return Cnpj
     */

    public static function validate($number) {
        Cleaner::cleanNumber($number);

        if(preg_match(self::REGEX, $number)) {

            if(self::getDigit(1, $number) == $number[12] && self::getDigit(2, $number) == $number[13]){
                return new Cnpj($number);
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
    
    private static function getDigit($k, $num) {
        $sum = 0;

        for($i = 0, $j = 4 + $k; $i < 11 + $k; $i++, $j--) {
            $j = $j < 2 ? 9 : $j;
            $sum += $num[$i] * $j;
        }

        return ($sum % 11 < 2) ? 0 : (11 - $sum % 11);
    }

    /**
     * getNumber
     *
     * @param  mixed $formatted
     *
     * @return string
     */

    public function getNumber($formatted = true) {
        return $formatted ? Masker::mask("##.###.###/####-##", $this->number) : $this->number;
    }
}