<?php
namespace Cajudev\Validator;

use Cajudev\Validator\Utils\Cleaner;
use Cajudev\Validator\Utils\Masker;
use Cajudev\CsvParser;

/**
 *
 * Validate creditcard numbers
 * 
 *  @author Richard Lopes
 */

class CreditCard
{
    private static $regex;
    private $number;
    private $flag;

    private function __construct(string $number, string $flag)
    {
        $this->number = $number;
        $this->flag   = $flag;
    }
    
    /**
     * validate
     *
     * @param  string $number
     *
     * @return CreditCard
     */

    public static function validate(string $number) : ?CreditCard
    {
        Cleaner::cleanNumber($number);

        if (self::checkLuhnAlgorithm($number) && $flag = self::findFlag($number)) {
            return new CreditCard($number, $flag);
        }

        return null;
    }

    /**
     * validateArray
     *
     * @param  array $array
     *
     * @return array
     */

    public static function validateArray(array $array) : array
    {
        $ret = [];
        foreach ($array as $element) {
            if ($number = self::validate($element)) {
                $ret[] = $number;
            }
        }
        return $ret;
    }

    private static function findFlag(string $number)
    {
        foreach (self::getRegex() as $key => $value) {
            if (preg_match($value, $number)) {
                return $key;
            }
        }
        return false;
    }

    private static function checkLuhnAlgorithm(string $number) : bool
    {
        $reverse = strrev($number);

		for ($i = 1, $size = strlen($reverse); $i < $size; $i++) {
            if ($i % 2 == 1) {
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

    public function getFlag() : string
    { 
        return $this->flag;
    }

    /**
     * getNumber
     *
     * @param  bool $formatted
     *
     * @return string
     */

    public function getNumber(bool $formatted = true) : string
    {
        if (!$formatted) {
            return $this->number;
        }
        
        switch (strlen($this->number)) {
            case 16: return Masker::mask("#### #### #### ####", $this->number);
            case 15: return Masker::mask("#### ###### #####", $this->number);
            case 14: return Masker::mask("#### ###### ####", $this->number);
        }
    }

    private static function getRegex() : array
    {
        if (empty(self::$regex)) {
            self::setRegex();
        }

        return self::$regex;
    }
    
    private static function setRegex() {
        self::$regex['visa']       = '/^4[0-9]{12}(?:[0-9]{3})?$/';
        self::$regex['mastercard'] = '/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/';
        self::$regex['amex']       = '/^3[47][0-9]{13}$/';
        self::$regex['diners']     = '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/';
        
        //extracting all elo bins from oficial file
        $dir = getcwd() . '/storage/creditcard/bin-table-elo.csv';
        $csv = new CsvParser($dir);
        $bins = $csv->setDelimiter(';')
                    ->setColumns(['number'])
                    ->parse();

        //making elo regular expression
        $regex = '/^((';
        foreach ($bins as $bin) {
            $regex .= "({$bin['number']})|";
        }
        self::$regex['elo'] =  substr($regex, 0, strlen($regex) - 1) . ')[0-9]{10})$/';
    }
}
