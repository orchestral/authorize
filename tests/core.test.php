<?php

Bundle::start('orchestra');
Bundle::start('authorize');

class CoreTest extends Authorize\Testable\TestCase {

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		parent::tearDown();
		Config::$items = array();
	}
	/**
	 * Test Authorize\Core::sync() is run properly.
	 *
	 * @test
	 */
	public function testSyncIsSuccessful()
	{
		$role = Orchestra\Model\Role::create(array(
			'name' => 'Foo Admin',
		));

		Config::set('orchestra::orchestra.default_role', (int) $role->id);

		Authorize\Core::sync();

		$acl = Orchestra::acl();

		$this->assertTrue($acl->check($role->name, 'Manage Orchestra'));
		$this->assertTrue($acl->check($role->name, 'Manage Users'));
		$this->assertTrue($acl->check($role->name, 'Manage Roles'));
		$this->assertTrue($acl->check($role->name, 'Manage Acl'));
	}
}