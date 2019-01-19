<?php
namespace Cajudev\Validator\Document;

/**
 *
 * Validate brazilian documents
 * 
 *  @author Richard Lopes
 */

abstract class Document
{

    protected $number;

    protected function __construct(string $number)
    {
        $this->number = $number;
    }

    abstract protected static function validate(string $number);

    abstract protected static function validateArray(array $array) : array;
    
    abstract protected static function getDigit(int $k, string $num);

    abstract protected function getNumber(bool $formatted = true);
}
