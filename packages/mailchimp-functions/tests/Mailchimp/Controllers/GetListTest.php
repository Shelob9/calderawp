<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\GetList;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class GetListTest extends TestCase
{
	/**
	 * @covers \something\Mailchimp\Controllers\GetList::__invoke()
	 */
	public function test__invoke()
	{

		$data = (array)$this->getListData();
		foreach ( $data as &$datum ){
			if( is_object($datum)){
				$datum = (array)$datum;
			}
		}
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);

		$controller = new class($mailchimpApi) extends GetList {
			/**
			 * @inheritDoc
			 */
			protected function findById(int $id): SingleList
			{
				return (new SingleList())->setId($id);
			}

		};
		$listId = 'ad33221';
		$result = $controller->__invoke(7);
		$this->assertEquals(7, $result->getId());
	}
}
