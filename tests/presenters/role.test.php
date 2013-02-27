<?php namespace Authorize\Tests\Presenters;

\Bundle::start('orchestra');
\Bundle::start('authorize');

class PresentersRoleTest extends \Authorize\Testable\TestCase {

	/**
	 * Test instanceof Authorize\Presenter\Role::table()
	 *
	 * @test
	 */
	public function testInstanceOfRoleTable()
	{
		$role = \Orchestra\Model\Role::paginate(5);
		$stub = \Authorize\Presenter\Role::table($role);

		$refl = new \ReflectionObject($stub);
		$grid = $refl->getProperty('grid');
		$grid->setAccessible(true);
		$grid = $grid->getValue($stub);

		$this->assertInstanceOf('\Orchestra\Table', $stub);
		$this->assertEquals(\Orchestra\Table::of('authorize.roles'), $stub);
		$this->assertInstanceOf('\Orchestra\Support\Table\Grid', $grid);
	}

	/**
	 * Test instanceof Authorize\Presenter\Role::form()
	 *
	 * @test
	 */
	public function testInstanceOfRoleForm()
	{
		$role = new \Orchestra\Model\Role;
		$stub = \Authorize\Presenter\Role::form($role);

		$refl = new \ReflectionObject($stub);
		$grid = $refl->getProperty('grid');
		$grid->setAccessible(true);
		$grid = $grid->getValue($stub);

		$this->assertInstanceOf('\Orchestra\Form', $stub);
		$this->assertEquals(\Orchestra\Form::of('authorize.roles'), $stub);
		$this->assertInstanceOf('\Orchestra\Support\Form\Grid', $grid);
	}
}