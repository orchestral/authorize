<?php namespace Authorize\Tests\Presenters;

\Bundle::start('orchestra');
\Bundle::start('authorize');

class PresentersExtensionTest extends \Authorize\Testable\TestCase {

	/**
	 * Test Authorize\Presenter\Extension::table()
	 *
	 * @test
	 */
	public function testInstanceOfExtensionTable()
	{
		$stub = \Authorize\Presenter\Extension::form(
			\Orchestra\Form::of('foo', function () {})
		);

		$refl = new \ReflectionObject($stub);
		$grid = $refl->getProperty('grid');
		$grid->setAccessible(true);
		$grid = $grid->getValue($stub);

		$this->assertInstanceOf('\Orchestra\Form', $stub);
		$this->assertEquals(\Orchestra\Form::of('foo'), $stub);
		$this->assertInstanceOf('\Orchestra\Support\Form\Grid', $grid);
	}
}