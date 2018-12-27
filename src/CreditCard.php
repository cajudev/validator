<?php namespace Cajudev\Validator;

use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Validate creditcard numbers
 * 
 *  @author Richard Lopes
 */

class CreditCard {

    private const REGEX = array(
        'elo'        => '/^(((636368)|(636369)|(438935)|(504175)|(636297)|(506699))[0-9]{10})|(((5067)|(4514)|(4576)|(4011))[0-9]{12})$/',
        'visa'       => '/^4[0-9]{12}(?:[0-9]{3})?$/',
        'mastercard' => '/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/',
        'amex'       => '/^3[47][0-9]{13}$/',
        'diners'     => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/'
    );

    private $number;
    private $flag;

    private function __construct($number, $flag) {
        $this->number = $number;
        $this->flag   = $flag;
    }
    
    /**
     * validate
     *
     * @param  mixed $number
     *
     * @return CreditCard
     */

    public static function validate($number) {
        Cleaner::cleanNumber($number);

        if(self::checkLuhnAlgorithm($number) && $flag = self::findFlag($number)) {
            return new CreditCard($number, $flag);
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

    private static function findFlag($number) {
        foreach(self::REGEX as $key => $value) {
            if(preg_match($value, $number)) {
                return $key;
            }
        }
        return false;
    }

    private static function checkLuhnAlgorithm($number) {
        $reverse = strrev($number);

		for ($i = 1, $size = strlen($reverse); $i < $size; $i++) {
            if($i % 2 == 1) {
                $double = $reverse[$i] * 2;
                $reverse[$i] = $double > 9 ? $double - 9 : $double;
            }
        }

		return array_sum(str_split($reverse)) % 10 == 0;
    }

    /**
     * getFlag
     *
     * @return string
     */

    public function getFlag() { 
        return $this->flag;
    }

    /**
     * getNumber
     *
     * @param  mixed $formatted
     *
     * @return string
     */

    public function getNumber($formatted = true) {
        if($formatted){
            switch(strlen($this->number)) {
                case 16: return Masker::mask("#### #### #### ####", $this->number);
                case 15: return Masker::mask("#### ###### #####", $this->number);
                case 14: return Masker::mask("#### ###### ####", $this->number);
            }
        }
        return $this->number;
    }
}