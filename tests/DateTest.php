<?php
use Cajudev\Validator\Date;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class DateTest extends TestCase {

	public function setUp() {
		$this->date = new Date();
	}

    public function test_Should_ReturnFalse_When_DateNotMatch() {
        self::assertFalse($this->date->validate('01/02/2018', 'd-m-y'));
	}
	
	public function test_Should_ReturnTrue_When_DateMatch() {
        self::assertTrue($this->date->validate('01/02/2018', 'd/m/Y'));
	}
	
	public function test_Should_ReturnDate_When_DateIsSet() {
		$this->date->validate('01/02/2018', 'd/m/Y');
		self::assertEquals('01/02/2018', $this->date->getDate());
	}

	public function test_Should_ReturnNull_When_DateIsNotSet() {
		self::assertNull($this->date->getDate());
	}

	public function test_Should_ReturnDay_When_DayIsSet() {
		$this->date->validate('01/02/2018', 'd/m/Y');
		self::assertEquals('01', $this->date->getDay());
	}

	public function test_Should_ReturnNull_When_DayIsNotSet() {
		self::assertNull($this->date->getDay());
	}

	public function test_Should_ReturnMonth_When_MonthIsSet() {
		$this->date->validate('01/02/2018', 'd/m/Y');
		self::assertEquals('02', $this->date->getMonth());
	}

	public function test_Should_ReturnNull_When_MonthIsNotSet() {
		self::assertNull($this->date->getMonth());
	}

	public function test_Should_ReturnYear_When_YearIsSet() {
		$this->date->validate('01/02/2018', 'd/m/Y');
		self::assertEquals('2018', $this->date->getYear());
	}

	public function test_Should_ReturnNull_When_YearIsNotSet() {
		self::assertNull($this->date->getYear());
	}
}
