<?php
use Cajudev\Validator\Rg;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class RgTest extends TestCase {

	public function setUp(){
		$this->arrayRg = array(
			"32.331.620-7",
			"43.513.112-6",
			"26.178.384-1",
			"15.978.609-7",
			"43.230.111-X",
			"37.802.977-1",
		);
	}
	
	public function test_validate() {
		self::assertFalse(Rg::validate("43.230.111-9"));
		self::assertInstanceOf(Rg::class, Rg::validate("43.230.111-2"));
	}

	public function test_validateArray() {
		$array = Rg::validateArray($this->arrayRg);
		self::assertEquals(3, count($array));
    }
    
    public function test_getNumber() {
		$number = Rg::validate("43.230.115-x");
        self::assertEquals("43.230.115-X", $number->getNumber());
        self::assertEquals("43230115X", $number->getNumber(false));
	}
}
