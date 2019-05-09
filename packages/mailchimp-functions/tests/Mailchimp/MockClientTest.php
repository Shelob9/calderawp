<?php

namespace something\Tests\Mailchimp;


use Mailchimp\MailchimpLists;

class MockClientTest extends TestCase
{

	/**
	 * @covers \something\Tests\Mailchimp\MockClient::handleRequest()
	 * @covers \something\Tests\Mailchimp\MockClient::setNextResponseData()
	 */
	public function testNextResponse()
	{
		$client = new MockClient();
		$data = [1 => 'x', 'x' => 'one', 'r' => [1, 3]];
		$client->setNextResponseData($data);

		$this->assertEquals(
			$data,
			$client->handleRequest("GET")

		);

	}

	/**
	 * @covers \something\Tests\Mailchimp\MockClient::handleRequest()
	 * @covers \something\Tests\Mailchimp\MockClient::setNextResponseData()
	 */
	public function testHandleRequest()
	{
		$httpClient = new MockClient();
		$MailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$data = [1 => 'x', 'x' => 'one', 'r' => [1, 3]];
		$httpClient->setNextResponseData($data);
		$MailchimpApi->getList(1);
		$this->assertEquals( $data, $MailchimpApi->getLists() );

	}
}
