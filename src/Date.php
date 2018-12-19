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
        "d" => "(?<day>[0-2][1-9]|[1-3][0-1])",
        "m" => "(?<month>0[1-9]|1[0-2])",
        "y" => "(?<year>[0-9]{2})",
        "Y" => "(?<year>19[0-9]{2}|20[0-9]{2})"
    );

    private $date;
    private $day;
    private $month;
    private $year;

    public function __construct($params = array()){
        $this->date  = $params[0]       ?? null;
        $this->day   = $params['day']   ?? null;
        $this->month = $params['month'] ?? null;
        $this->year  = $params['year']  ?? null;
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
        return $this->day ?? null;
    }

    /**
     * getMonth
     *
     * @return string
     */
    
    public function getMonth() {
        return $this->month ?? null;
    }

    /**
     * getYear
     *
     * @return string
     */
    
    public function getYear() {
        return $this->year ?? null;
    }

    /**
     * getDate
     *
     * @return string
     */

    public function getDate() {
        return $this->date ?? null;
    }
}
