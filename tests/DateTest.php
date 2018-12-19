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

	public function test_validateArray(){
		$array = Date::validateArray($this->arrayDate, 'd-m-Y');
		self::assertInstanceOf(Date::class,$array[0]);
		self::assertFalse($array[1]);
		self::assertFalse($array[2]);
		self::assertFalse($array[3]);
		self::assertInstanceOf(Date::class,$array[4]);
	}
}
