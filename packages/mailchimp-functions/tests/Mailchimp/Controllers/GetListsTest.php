<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\GetLists;
use something\Mailchimp\Database\Lists;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class GetListsTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Controllers\GetLists::__invoke()
	 */
	public function test__invoke()
	{

		$data = (object)$this->getListsData();
		$httpClient = new MockClient();
		$MailchimpApi = new MailchimpLists('app', 'apikey', [], $httpClient);
		$httpClient->setNextResponseData($data);
		$accountId = 1;
		$controller = new class ($MailchimpApi) extends GetLists
		{
			protected function getSavedLists(int $accountId): array
			{
				return [
					(new SingleList())->setAccountId($accountId),
					(new SingleList())->setAccountId($accountId)->setId(2),
				];
			}

		};
		$result = $controller->__invoke($accountId);
		$this->assertCount(2, $result);
		$this->assertEquals($accountId, $result[0]->getAccountId());
		$this->assertEquals($accountId, $result[1]->getAccountId());
		$this->assertEquals(2, $result[1]->getId());
	}
}
