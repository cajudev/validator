<?php namespace Cajudev\Validator\Document;

use Cajudev\Validator\Document\Document;

use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Realiza a validação de RG's
 * 
 *  @author Richard Lopes
 */

class Rg extends Document {

    private const REGEX = '/^(?!(\d)\1{8})\d{9}|\d{8}[xX]$/';

    private function __construct($number) {
        parent::__construct($number);
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
            if(self::getDigit(1, $number) == $number[8]) {
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
    
    protected static function getDigit($k, $num) {
        $sum = 0;

        for($i = 0, $j = 1 + $k; $i < 7 + $k; $i++, $j++) {
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