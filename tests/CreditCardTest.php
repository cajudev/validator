<?php
use Cajudev\Validator\CreditCard;
use PHPUnit\Framework\TestCase;

/**
 * @author Richard Lopes
 */

class CreditCardTest extends TestCase {

    public function setUp() {
        $this->cards = json_decode(file_get_contents(__DIR__."/files/creditcards.json"), true);
    }
	
	public function test_validate() {
		self::assertFalse(CreditCard::validate("2615334"));
		self::assertInstanceOf(CreditCard::class, CreditCard::validate("5277 8876 3010 5547"));
	}

	public function test_validateArray() {
		$array = CreditCard::validateArray(array_column($this->cards, "number"));
		self::assertEquals(250, count($array));
    }
    
    public function test_getNumber() {
		$number = CreditCard::validate("5067931513802129");
        self::assertEquals("5067 9315 1380 2129", $number->getNumber());
        self::assertEquals("5067931513802129", $number->getNumber(false));
        
        $number = CreditCard::validate("372141991176589");
        self::assertEquals("3721 419911 76589", $number->getNumber());
        self::assertEquals("372141991176589", $number->getNumber(false));

        $number = CreditCard::validate("30057669516662");
        self::assertEquals("3005 766951 6662", $number->getNumber());
        self::assertEquals("30057669516662", $number->getNumber(false));
    }
    
    public function test_getFlag() {
        foreach($this->cards as $card) {
            $creditCard = CreditCard::validate($card['number']);
            self::assertEquals($card['flag'], $creditCard->getFlag());
        }
	}
}
