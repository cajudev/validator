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
        "Y" => "(?<Year>19[0-9]{2}|20[0-9]{2})",
    );

    private $day;
    private $month;
    private $year;

    public function validate($date, $string) {
        $regex = $this->getRegex($string);
        if (preg_match($regex, $date, $match)) {
            $this->make($match);
            return true;
        }
        return false;
    }

    private  function make($params) {
        $this->date = $params[0] ?? null;
        $this->day = $params['day'] ?? null;
        $this->month = $params['month'] ?? null;
        $this->year = $params['year'] ?? $params['Year'] ?? null;
    }

    private function getRegex($string) {
        $regex = '/^';
        $regex .= self::REGEX[$string[0]];
        $regex .= "\\" . $string[1];
        $regex .= self::REGEX[$string[2]];
        $regex .= "\\" . $string[3];
        $regex .= self::REGEX[$string[4]];
        $regex .= '$/';
        return $regex;
    }

    public function getDay() {
        return $this->day ?? null;
    }

    public function getMonth() {
        return $this->month ?? null;
    }

    public function getYear() {
        return $this->year ?? null;
    }

    public function getDate() {
        return $this->date ?? null;
    }
}
