<?php

namespace something\Tests\Mailchimp;

use GuzzleHttp\Client;
use something\Mailchimp\HttpClient;

class HttpClientTest extends TestCase
{
	/**
	 * @covers \something\Mailchimp\HttpClient::setGuzzle()
	 * @covers \something\Mailchimp\HttpClient::getGuzzle()
	 */
	public function testSetGuzzle()
	{

		$http = new HttpClient();
		$this->assertTrue(
			$http->getGuzzle()->getConfig()['verify']
		);

		$guzzle = new Client(['verify' => false ]);

		$http->setGuzzle($guzzle);
		$this->assertSame($guzzle, $http->getGuzzle());
		$this->assertFalse(
			$http->getGuzzle()->getConfig()['verify']
		);
	}
	/**
	 * @covers \something\Mailchimp\HttpClient::getGuzzle()
	 */
	public function testGetGuzzle()
	{
		$http = new HttpClient();
		$this->assertTrue(
			$http->getGuzzle()->getConfig()['verify']
		);
		$this->assertTrue($http->getGuzzle()->getConfig()['decode_content']);


		$config = ['decode_content' => false ];
		$http = new HttpClient($config);
		$this->assertFalse($http->getGuzzle()->getConfig()['decode_content']);

	}
}
