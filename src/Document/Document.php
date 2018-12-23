<?php namespace Cajudev\Validator\Document;

/**
 *
 * Realiza a validação de Documentos
 * 
 *  @author Richard Lopes
 */

abstract class Document {

    protected $number;

    protected function __construct($number) {
        $this->number = $number;
    }

    protected abstract static function validate($number);

    protected abstract static function validateArray($array);
    
    protected abstract static function getDigit($k, $num);

    protected abstract function getNumber($formatted = true);
}