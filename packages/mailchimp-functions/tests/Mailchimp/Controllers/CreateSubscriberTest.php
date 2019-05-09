<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\CreateSubscriber;
use something\Mailchimp\Entities\SingleList;
use something\Mailchimp\Entities\Subscriber;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class CreateSubscriberTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Controllers\CreateSubscriber::__invoke()
	 */
	public function test__invoke()
	{
		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$groupId1 = $groups[ 0 ]->id;
		$groupdId2 = $groups[ 1 ]->id;
		$mergeId1 = $mergeVars[ 0 ]->merge_id;
		$mergeId2 = $mergeVars[ 1 ]->merge_id;
		$email = 'roy@hiroy.club';
		/** @var Subscriber $subscriber */
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email,
			'status' => 'pending',
			'subscribeMergeVars' => [
				$mergeId1 => false,
				$mergeId2 => true,
			],
			'subscribeGroups' => [
				$groupId1 => false,
				$groupdId2 => true,
			]
		]);

		$data = new \stdClass();
		$data->id = '111a';
		$data->status ='sucess';
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);

		$listId = 'ad33221';

		$controller = new class($mailchimpApi) extends  CreateSubscriber {
			public function getSavedList(string $listId): SingleList
			{
				return (new SingleList())
					->setListId($listId);
			}
		};

		$response = $controller->__invoke($subscriber,$listId);
		$this->assertEquals($data->status,$response['status']);
		$this->assertEquals($data->id,$response['id']);
		$this->assertTrue($response['success']);
		$this->assertArrayHasKey('message', $response);

	}
}
