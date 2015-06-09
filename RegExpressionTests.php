<?php
/**
 * Test class for checking regular expressions
 * @author John Lennon
 * */
require_once '../simpletest/autorun.php';
echo "Tests Name / Model input";
class RegExpressionTests extends UnitTestCase 
{
	private $validation ;
	public function setUp () 
	{
		require_once '../slimapp/models/validation_functions.php';
		$this->validation = new validation_functions();
	}

	public function testEmptyAndStrangeEntries() 
	{
		$this->assertFalse ($this->validation->isInputValid ("") ) ;
		$this->assertFalse ($this->validation->isInputValid ("HoNdA"));
		$this->assertFalse ($this->validation->isInputValid ("H0nda"));
		$this->assertFalse ($this->validation->isInputValid ("_Honda"));
		$this->assertFalse ($this->validation->isInputValid (" Honda"));
		$this->assertFalse ($this->validation->isInputValid ("h onda"));
		$this->assertFalse ($this->validation->isInputValid ("Honda!"));
		$this->assertFalse ($this->validation->isInputValid ("MAzda"));
		$this->assertFalse ($this->validation->isInputValid ("MaZdA"));
		$this->assertFalse ($this->validation->isInputValid ("VoLkSWaGeN"));
		$this->assertFalse ($this->validation->isInputValid ("VW"));
		$this->assertFalse ($this->validation->isInputValid ("WV"));
	}
	public function testModelAfterName() 
	{
		$this->assertFalse ($this->validation->isInputValid ("Honda Accord"));
		$this->assertFalse ($this->validation->isInputValid ("Honda_Accord"));
		$this->assertFalse ($this->validation->isInputValid ("honda accord"));
		$this->assertFalse ($this->validation->isInputValid ("VW_Golf"));
		$this->assertFalse ($this->validation->isInputValid ("Mazda M5"));
		$this->assertFalse ($this->validation->isInputValid ("ford_escort"));
		$this->assertFalse ($this->validation->isInputValid ("ford_mondeo"));
		$this->assertFalse ($this->validation->isInputValid ("fiat_punto"));
	}
	public function tearDown() 
	{
		$this->validation = null;
	}

}
?>