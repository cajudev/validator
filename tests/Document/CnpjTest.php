<?php
use Cajudev\Validator\Document\Cnpj;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class CnpjTest extends TestCase {

	public function setUp(){
		$this->arrayCnpj = array(
			"58.929.896/0001-78",
			"57.806.461/0001-74",
			"09.475.795/0001-69",
			"60.184.969/0001-81",
			"87.048.150/0001-53"
		);
	}
	
	public function test_validate() {
		self::assertNull(Cnpj::validate("72.143.232/0001-01"));
		self::assertInstanceOf(Cnpj::class, Cnpj::validate("72.143.232/0001-00"));
	}

	public function test_validateArray(){
		$array = Cnpj::validateArray($this->arrayCnpj);
		self::assertEquals(3, count($array));
    }
    
    public function test_getNumber(){
		$number = Cnpj::validate("60.342.988/0001-07");
        self::assertEquals("60.342.988/0001-07", $number->getNumber());
        self::assertEquals("60342988000107", $number->getNumber(false));
	}
}
