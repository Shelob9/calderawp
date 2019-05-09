<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\GetCategories;
use something\Mailchimp\Controllers\FindGroups;
use something\Mailchimp\Entities\Groups;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class FindGroupsTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Controllers\GetCategories::__invoke()
	 */
	public function test__invoke()
	{
		$data = (array)$this->getGroupsData();
		foreach ( $data as &$datum ){
			if( is_object($datum)){
				$datum = (array)$datum;
			}
		}
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);

		$controller = new FindGroups($mailchimpApi);
		$listId = 'ad33221';
		$result = $controller->__invoke($listId);
		$this->assertCount(2, $result);
		$this->assertEquals($listId, $result['listId']);
		$this->assertInstanceOf(Groups::class, $result['groups']);

	}
}
