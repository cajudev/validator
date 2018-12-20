<?php namespace Cajudev\Validator;

/**
 *
 * Date Class
 *
 * Realiza a validação de datas num intervalo entre 1900 - 2099
 * 
 *  @author Richard Lopes
 */

class Date {

    const REGEX = array(
        "d" => "(?<day>[3][0-1]|[1-2][0-9]|0[1-9])",
        "j" => "(?<day>[3][0-1]|[1-2][0-9]|[1-9])",
        "m" => "(?<month>1[0-2]|0[1-9])",
        "n" => "(?<month>1[0-2]|[1-9])",
        "y" => "(?<year>[0-9]{2})",
        "Y" => "(?<year>19[7-9][0-9]|20[0-9]{2})"
    );

    private $date;
    private $day;
    private $month;
    private $year;
    private $timestamp;

    private function __construct($params = array()) {
        $this->date      = $params[0];
        $this->day       = $params['day'];
        $this->month     = $params['month'];
        $this->year      = $params['year'];
        $this->timestamp = strtotime($this->year . '-' . $this->month . '-' . $this->day);
    }

    /**
     * validate - Realiza a validação de uma data
     *
     * @param  mixed $date - A string contendo a data a ser validada
     * @param  mixed $string - A string contendo o formato a ser analisado
     *
     * @return boolean
     */
    
    public static function validate($date, $pattern) {
        self::validatePattern($pattern);

        $regex = self::getRegex($pattern);
        if(preg_match($regex, $date, $match)) {
            if(checkdate($match['month'], $match['day'], $match['year'])) {
                return new Date($match);
            }
        }
        return false;
    }

    public static function validateArray($array, $pattern) {
        foreach($array as $element) {
            $ret[] = self::validate($element, $pattern);
        }
        return $ret;
    }

    private static function validatePattern($pattern) {
        if(!preg_match("/^[djmny][.\/-][djmny][.\/-][djmny]$/i", $pattern)){
            throw new \Exception("Illegal pattern input");
        }
    }

    private static function getRegex($pattern) {
        $regex  = '/^';
        $regex .= self::REGEX[$pattern[0]];
        $regex .= "\\" . $pattern[1];
        $regex .= self::REGEX[$pattern[2]];
        $regex .= "\\" . $pattern[3];
        $regex .= self::REGEX[$pattern[4]];
        $regex .= '$/';
        return $regex;
    }

    /**
     * getDay
     *
     * @return string
     */
    
    public function getDay() {
        return $this->day;
    }

    /**
     * getMonth
     *
     * @return string
     */
    
    public function getMonth() {
        return $this->month;
    }

    /**
     * getYear
     *
     * @return string
     */
    
    public function getYear() {
        return $this->year;
    }

    /**
     * getDate
     *
     * @return string
     */

    public function getDate($pattern = '') {
        if($pattern == ''){
            return $this->date;
        }else{
            self::validatePattern($pattern);
            return date($pattern, $this->timestamp);
        }
    }
}
