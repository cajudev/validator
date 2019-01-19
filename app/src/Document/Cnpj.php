<?php
namespace Cajudev\Validator\Document;

use Cajudev\Validator\Document\Document;
use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 *  Validate brazilian cnpj numbers
 * 
 *  @author Richard Lopes
 */

class Cnpj extends Document
{

    private const REGEX = '/^(?!(\d)\1{13})\d{14}$/';

    private function __construct(string $number)
    {
        parent::__construct($number);
    }
    
    /**
     * validate
     *
     * @param  string $number
     *
     * @return Cnpj
     */

    public static function validate(string $number) : ?Cnpj
    {
        Cleaner::cleanNumber($number);

        if (!preg_match(self::REGEX, $number)) {
            return null;
        }

        if (self::getDigit(1, $number) !== $number[12] || self::getDigit(2, $number) !== $number[13]) {
            return null;
        }

        return new Cnpj($number);
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

        for($i = 0, $j = 4 + $k; $i < 11 + $k; $i++, $j--) {
            $j = $j < 2 ? 9 : $j;
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
        return $formatted ? Masker::mask("##.###.###/####-##", $this->number) : $this->number;
    }
}
