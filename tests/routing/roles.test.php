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
	public function testGetListOfRoles()
	{
		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize.roles');

		$this->assertInstanceOf('Laravel\Response', $response);
		$this->assertEquals(200, $response->foundation->getStatusCode());

		$content = $response->content->data['content'];

		$this->assertInstanceOf('Laravel\Response', $content);
		$this->assertEquals('authorize::roles.index', $content->content->view);
	}
}