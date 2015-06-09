<?php
/**
 * Test class for checking regular expressions
 * Web Api assignment - Enterprise Application Development
 * @author John Lennon
 * */
class validation_functions
{
	 /**
	 * check whether the input string is valid using regular expressions
	*/
	public function isInputValid ($inputStr ) 
	{
		$regex = '/^[a-zA-Z0-9- ]+(\.[_a-zA-Z0-9- ])/';
		if(!preg_match($regex , $inputStr ) ) return (false) ;
		else return (true) ;
	}
}
?>