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

    private const REGEX = [
        'elo' => '/(?x) ^((?<bin>
            (509042)|(509045)|(509048)|(509051)|(509052)|(509053)|(509054)|(509055)|(509056)|(509057)|(509058)|(509059)|(509060)|(509070)|(509071)|(650406)|
            (650409)|(650410)|(650434)|(650435)|(650436)|(650439)|(650587)|(650588)|(650589)|(650724)|(650725)|(509061)|(509062)|(509063)|(509064)|(509066)|
            (509067)|(509068)|(509069)|(509074)|(509077)|(509078)|(509079)|(509080)|(509084)|(506730)|(506731)|(509091)|(509092)|(509098)|(509100)|(509106)|
            (509107)|(509108)|(509109)|(636368)|(650407)|(650408)|(650485)|(650486)|(650487)|(650488)|(650489)|(650490)|(650491)|(650492)|(650493)|(506732)|
            (506733)|(650494)|(650495)|(650496)|(650497)|(650498)|(650499)|(650500)|(650501)|(650502)|(650503)|(650504)|(650506)|(650507)|(650508)|(650509)|
            (650510)|(650511)|(650512)|(650513)|(650514)|(650515)|(650516)|(650517)|(650518)|(650519)|(650520)|(650521)|(650522)|(650523)|(650524)|(650525)|
            (650526)|(650527)|(650528)|(650529)|(506739)|(506741)|(650530)|(650577)|(650578)|(650579)|(650580)|(650582)|(650585)|(650586)|(650590)|(650721)|
            (650722)|(650723)|(650726)|(650727)|(650901)|(650902)|(650903)|(650904)|(650905)|(650906)|(650907)|(650908)|(650909)|(650910)|(650911)|(650912)|
            (650913)|(650962)|(650914)|(650915)|(650916)|(650917)|(650918)|(650919)|(650920)|(650921)|(650922)|(506742)|(650928)|(650939)|(650946)|(650947)|
            (650948)|(650954)|(650955)|(650963)|(650967)|(650971)|(651652)|(651653)|(651654)|(651655)|(651656)|(651657)|(651658)|(651659)|(651660)|(655052)|
            (651661)|(651662)|(651663)|(651664)|(651665)|(651666)|(651667)|(651675)|(651676)|(651677)|(651678)|(655000)|(655001)|(655002)|(655003)|(655004)|
            (655005)|(655006)|(655007)|(655008)|(655009)|(655010)|(655012)|(655013)|(655014)|(655015)|(655051)|(655056)|(655057)|(509035)|(509039)|(509040)|
            (509041)|(506743)|(506745)|(506746)|(506747)|(506753)|(506774)|(506775)|(506778)|(509000)|(509001)|(509007)|(509020)|(509021)|(506707)|(506708)|
            (506715)|(506718)|(506719)|(506720)|(506721)|(506724)|(506726)|(506727)|(506728)|(506729)|(509022)|(650583)|(650584))[0-9]{10})$/',

        'visa'       => '/^4[0-9]{12}(?:[0-9]{3})?$/',
        'mastercard' => '/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/',
        'amex'       => '/^3[47][0-9]{13}$/',
        'diners'     => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
    ];

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

    public static function validate($number) : ?CreditCard {
        Cleaner::cleanNumber($number);

        if(self::checkLuhnAlgorithm($number) && $flag = self::findFlag($number)) {
            return new CreditCard($number, $flag);
        }

        return null;
    }

    /**
     * validateArray
     *
     * @param  mixed $array
     * @param  mixed $pattern
     *
     * @return array
     */

    public static function validateArray(array $array) : array {
        $ret = [];
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