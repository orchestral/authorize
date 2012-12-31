<?php

Bundle::start('orchestra');
Bundle::start('authorize');

class StrTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test Authorize\Str::humanize() method.
	 *
	 * @test
	 */
	public function testHumanizeSuccessful()
	{
		$expected = 'Foobar Is Awesome';
		$output   = Authorize\Str::humanize('foobar-is-awesome');

		$this->assertEquals($expected, $output);
	}
}