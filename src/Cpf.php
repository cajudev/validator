<?php namespace Cajudev\Validator;

/**
 *
 * Realiza a validação de CPF's
 * 
 *  @author Richard Lopes
 */

class Cpf {

    private const REGEX = '/^(?!(\d)\1{10})\d{11}$/';

    private $number;

    private function __construct($number){
        $this->number = $number;
    }
    
    /**
     * validate
     *
     * @param  mixed $number
     *
     * @return Cpf
     */

    public static function validate($number) {
        self::clean($number);

        if(preg_match(self::REGEX, $number)) {
            if(self::getFirstDigit($number) == $number[9] && self::getSecondDigit($number) == $number[10]){
                return new Cpf($number);
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
            if($number = self::validate($element)){
                $ret[] = $number;
            }
        }
        return $ret;
    }
    
    private static function getFirstDigit($num) {
        $sum = 0;

        for($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $sum += $num[$i] * $j;
        }

        return ($sum % 11 < 2) ? 0 : (11 - $sum % 11);
    }

    private static function getSecondDigit($num) {
        $sum = 0;

        for($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum += $num[$i] * $j;
        }

        return ($sum % 11 < 2) ? 0 : (11 - $sum % 11);
    }

    private static function clean(&$number) {
        $number = preg_replace("/[^0-9]/", "", $number);
    }

    /**
     * getNumber
     *
     * @param  mixed $formatted
     *
     * @return string
     */

    public function getNumber($formatted = true) {
        return $formatted ? $this->getFormatted() : $this->number;
    }

    private function getFormatted() {
        $num = str_split($this->number, 3);
        return $num[0] . "." . $num[1] . "." . $num[2] . "-" . $num[3];
    }
}