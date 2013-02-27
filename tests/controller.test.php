<?php namespace Authorize\Tests;

\Bundle::start('authorize');

class ControllerTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Test Controller is using restful verb.
	 *
	 * @test
	 */
	public function testControllerIsUsingRestfulVerb()
	{
		$controller = new ControllerStub;
		$refl       = new \ReflectionObject($controller);
		$restful    = $refl->getProperty('restful');

		$this->assertTrue($restful->getValue($controller));
		$this->assertTrue($controller->restful);
	}
}

class ControllerStub extends \Authorize\Controller {}