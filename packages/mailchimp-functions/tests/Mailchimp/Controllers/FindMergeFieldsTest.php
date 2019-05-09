<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\FindMergeFields;
use something\Mailchimp\Entities\MergeVars;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class GetMergeFieldsTest extends TestCase
{
	/**
	 * @covers \something\Mailchimp\Controllers\FindMergeFields::__invoke()
	 */
	public function test__invoke()
	{
		$data = (array)$this->getMergeFieldsData();
		foreach ( $data as &$datum ){
			if( is_object($datum)){
				$datum = (array)$datum;
			}
		}

		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);

		$controller = new FindMergeFields($mailchimpApi);
		$listId = 'ad33221';
		$result = $controller->__invoke($listId);
		$this->assertEquals($listId, $result['listId']);
		$this->assertInstanceOf(MergeVars::class, $result['mergeFields']);
		$this->assertEquals($listId, $result['mergeFields']->getListId());
	}
}
