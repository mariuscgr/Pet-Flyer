<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	public function setUp()
	{
		parent::setUp();
	}
	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	public function testBasicExample1()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());

		$this->assertCount(1, $crawler->filter('p:contains("Created by")'));
		$this->assertResponseStatus(200);
	}
}