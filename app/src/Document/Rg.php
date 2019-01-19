<?php
namespace Cajudev\Validator\Document;

use Cajudev\Validator\Document\Document;
use Cajudev\Validator\Utils\Masker;
use Cajudev\Validator\Utils\Cleaner;

/**
 *
 * Validate brazilian rg numbers
 * 
 *  @author Richard Lopes
 */

class Rg extends Document
{

    private const REGEX = '/^(?!(\d)\1{8})\d{9}|\d{8}[xX]$/';

    private function __construct(string $number)
    {
        parent::__construct($number);
    }
    
    /**
     * validate
     *
     * @param  string $number
     *
     * @return Rg
     */

    public static function validate(string $number) : ?Rg
    {
        Cleaner::cleanNumber($number, "xX");
        $number = strtoupper($number);

        if (!preg_match(self::REGEX, $number)) {
            return null;
        }

        if (self::getDigit(1, $number) !== $number[8]) {
            return null;
        }
        
        return new Rg($number);
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

        for ($i = 0, $j = 1 + $k; $i < 7 + $k; $i++, $j++) {
            $sum += $num[$i] * $j;
        }

        switch ($sum % 11) {
            case 0:
                return 0;
            case 1:
                return 'X';
            default:
                return 11 - $sum % 11;
        }
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
        return $formatted ? Masker::mask("##.###.###-#", $this->number) : $this->number;
    }
}
