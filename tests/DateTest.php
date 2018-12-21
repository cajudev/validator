<?php
use Cajudev\Validator\Date;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class DateTest extends TestCase {

	public function setUp(){
		$this->date = "01/02/2018";

		$this->arrayDate = array(
			"01-01-2015",
			"31/12/2018",
			"32/01/2015",
			"2018-05-01",
			"29-02-2020"
		);
	}
	
	public function test_validate() {
		self::assertFalse(Date::validate($this->date, 'd-m-y'));
		self::assertInstanceOf(Date::class, Date::validate($this->date, 'd/m/Y'));
	}

	public function test_getInfo(){
		$date = Date::validate('01/02/2018', 'd/m/Y');
		self::assertEquals("01/02/2018", $date->getDate());
		self::assertEquals("2018-02-01", $date->getDate('Y-m-d'));
		self::assertEquals("02.2018.01", $date->getDate('m.Y.d'));
		self::assertEquals("02-01-18",   $date->getDate('m-d-y'));
		self::assertEquals("01",         $date->getDay());
		self::assertEquals("02",         $date->getMonth());
		self::assertEquals("2018",       $date->getYear());
		self::assertEquals("1517443200", $date->getTimestamp());
	}

	public function test_validateArray(){
		$array = Date::validateArray($this->arrayDate, 'd-m-Y');
		self::assertEquals(2, count($array));
	}
}
