<?php

Bundle::start('orchestra');
Bundle::start('authorize');

class RoutingRolesTest extends Authorize\Testable\TestCase {
	
	/**
	 * User instance.
	 *
	 * @var Orchestra\Model\User
	 */
	public $user = null;

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		parent::setUp();

		$this->user = Orchestra\Model\User::find(1);
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		unset($this->user);

		parent::tearDown();
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles is successful.
	 *
	 * @test
	 */
	public function testGetIndexIsSuccessful()
	{
		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize.roles');

		$this->assertInstanceOf('Laravel\Response', $response);
		$this->assertEquals(200, $response->foundation->getStatusCode());

		$content = $response->content->data['content'];

		$this->assertInstanceOf('Laravel\Response', $content);
		$this->assertEquals('authorize::roles.index', $content->content->view);
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles failed without
	 * auth.
	 *
	 * @test
	 */
	public function testGetIndexFailedWithoutAuth()
	{
		$this->be(null);

		$response = $this->call('orchestra::resources@authorize.roles');

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());
		$this->assertEquals(handles('orchestra::login'),
			$response->foundation->headers->get('location'));
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles/view is successful.
	 *
	 * @test
	 */
	public function testGetNewRoleIsSuccessful()
	{
		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize.roles', array('view'));

		$this->assertInstanceOf('Laravel\Response', $response);
		$this->assertEquals(200, $response->foundation->getStatusCode());

		$content = $response->content->data['content'];

		$this->assertInstanceOf('Laravel\Response', $content);
		$this->assertEquals('authorize::roles.edit', $content->content->view);
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles/view failed without
	 * auth.
	 *
	 * @test
	 */
	public function testGetNewRoleFailedWithoutAuth()
	{
		$this->be(null);

		$response = $this->call('orchestra::resources@authorize.roles', array('view'));

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());
		$this->assertEquals(handles('orchestra::login'),
			$response->foundation->headers->get('location'));
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles/delete is 
	 * successful.
	 *
	 * @test
	 */
	public function testGetDeleteIsSuccessful()
	{
		$editor = Orchestra\Model\Role::create(array('name' => 'Editor'));
		$acl    = Orchestra::acl();

		$this->assertTrue($acl->has_role('editor'));

		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize.roles', array(
			'delete', 
			$editor->id,
		));

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());

		$this->assertTrue(is_null(Orchestra\Model\Role::find($editor->id)));
		$this->assertFalse($acl->has_role('editor'));
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles/delete failed 
	 * if trying to delete default role.
	 *
	 * @test
	 */
	public function testGetDeleteFailedIfDeletingDefaultRole()
	{
		$default_role = Config::get('orchestra::orchestra.default_role');
		$acl          = Orchestra::acl();

		$this->assertNotNull($default_role);

		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize.roles', array(
			'delete', 
			$default_role,
		));

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());

		$role = Orchestra\Model\Role::find($default_role);

		$this->assertFalse(is_null($role));
		$this->assertTrue($acl->has_role($role->name));
	}

	/**
	 * Test Request GET (orchestra)/resources/authorize.roles/delete failed 
	 * without auth.
	 *
	 * @test
	 */
	public function testGetDeleteFailedWithoutAuth()
	{
		$this->be(null);

		$response = $this->call('orchestra::resources@authorize.roles', array('delete', 1));

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());
		$this->assertEquals(handles('orchestra::login'),
			$response->foundation->headers->get('location'));
	}
}