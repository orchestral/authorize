<?php

Bundle::start('orchestra');
Bundle::start('authorize');

class RoutingHomeTest extends Authorize\Testable\TestCase {
	
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
	 * Test Request GET (orchestra)/resources/authorize is successful.
	 *
	 * @test
	 */
	public function testGetLandingPage()
	{
		$this->be($this->user);

		$response = $this->call('orchestra::resources@authorize');

		$this->assertInstanceOf('Laravel\Response', $response);
		$this->assertEquals(200, $response->foundation->getStatusCode());

		$content = $response->content->data['content'];

		$this->assertInstanceOf('Laravel\Response', $content);
		$this->assertEquals('authorize::home', $content->content->view);
	}
}