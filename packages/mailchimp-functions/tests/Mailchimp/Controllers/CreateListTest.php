<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\CreateList;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class CreateListTest extends TestCase
{

	public function test__invoke()
	{
		$this->markTestSkipped('need to mock all three requests' );
		$data = (array)$this->getListData();
		foreach ( $data as &$datum ){
			if( is_object($datum)){
				$datum = (array)$datum;
			}
		}
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);


		$controller = new class($mailchimpApi) extends CreateList{
			/**
			 * @inheritDoc
			 */
			protected function create(array $data): SingleList
			{
				return SingleList::fromArray($data);
			}

		};
		$result = $controller->__invoke($data['id'],1);
		$this->assertEquals(12, $result->getAccountId() );
		$this->assertEquals($data['id'], $result->getListId() );

	}
}
