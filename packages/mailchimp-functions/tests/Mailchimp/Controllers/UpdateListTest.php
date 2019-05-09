<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\UpdateList;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class UpdateListTest extends TestCase
{

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


		$controller = new class($mailchimpApi) extends UpdateList {
			protected function findById(int $id): SingleList
			{
				return (new SingleList())->setId($id)->setAccountId(7)->setListId('foo');
			}

			protected function update(SingleList $data): SingleList
			{
				return $data;
			}


		};
		$result = $controller->__invoke(12,[],[],[]);
		$this->assertEquals(12, $result->getId() );
		$this->assertEquals(7, $result->getAccountId() );
		$this->assertEquals('foo', $result->getListId() );
	}
}
