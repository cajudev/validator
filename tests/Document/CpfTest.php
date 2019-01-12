<?php
use Cajudev\Validator\Document\Cpf;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */
class CpfTest extends TestCase {

	public function setUp(){
		$this->arrayCpf = array(
			"438.784.570-81",
			"231.803.290-41",
			"477.107.930-69",
			"041.830.100-04",
			"769.611.670-55"
		);
	}
	
	public function test_validate() {
		self::assertNull(Cpf::validate("590.887.600-40"));
		self::assertInstanceOf(Cpf::class, Cpf::validate("590.887.600-39"));
	}

	public function test_validateArray(){
		$array = Cpf::validateArray($this->arrayCpf);
		self::assertEquals(3, count($array));
    }
    
    public function test_getNumber(){
		$number = Cpf::validate("014.126.000-90");
        self::assertEquals("014.126.000-90", $number->getNumber());
        self::assertEquals("01412600090", $number->getNumber(false));
	}
}
