<?php namespace Cajudev\Validator\Document;

use Cajudev\Validator\Document\Document;

use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Realiza a validação de CPF's
 * 
 *  @author Richard Lopes
 */

class Cpf extends Document {

    private const REGEX = '/^(?!(\d)\1{10})\d{11}$/';

    private function __construct($number){
        parent::__construct($number);
    }
    
    /**
     * validate
     *
     * @param  mixed $number
     *
     * @return Cpf
     */

    public static function validate($number) {
        Cleaner::cleanNumber($number);

        if(preg_match(self::REGEX, $number)) {
            if(self::getDigit(1, $number) == $number[9] && self::getDigit(2, $number) == $number[10]){
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
    
    protected static function getDigit($k, $num) {
        $sum = 0;

        for($i = 0, $j = 9 + $k; $i < 8 + $k; $i++, $j--) {
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
        return $formatted ? Masker::mask("###.###.###-##", $this->number) : $this->number;
    }
}