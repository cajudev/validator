<?php
namespace Cajudev\Validator\Document;

use Cajudev\Validator\Document\Document;
use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Validate brazilian cpf numbers
 * 
 *  @author Richard Lopes
 */

class Cpf extends Document
{

    private const REGEX = '/^(?!(\d)\1{10})\d{11}$/';

    private function __construct(string $number)
    {
        parent::__construct($number);
    }
    
    /**
     * validate
     *
     * @param  string $number
     *
     * @return Cpf
     */

    public static function validate(string $number) : ?Cpf
    {
        Cleaner::cleanNumber($number);

        if (!preg_match(self::REGEX, $number)) {
            return null;
        }

        if (self::getDigit(1, $number) !== $number[9] || self::getDigit(2, $number) !== $number[10]) {
            return null;
        }
        
        return new Cpf($number);
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
    
    protected static function getDigit(int $k, string $num) : string
    {
        $sum = 0;

        for ($i = 0, $j = 9 + $k; $i < 8 + $k; $i++, $j--) {
            $sum += $num[$i] * $j;
        }

        return ($sum % 11 < 2) ? 0 : (11 - $sum % 11);
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
        return $formatted ? Masker::mask("###.###.###-##", $this->number) : $this->number;
    }
}
