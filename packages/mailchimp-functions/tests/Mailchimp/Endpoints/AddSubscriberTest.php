<?php

namespace something\Tests\Mailchimp\Endpoints;

use calderawp\caldera\restApi\Request;
use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\CreateSubscriber;
use something\Mailchimp\Controllers\MailchimpProxy;
use something\Mailchimp\Endpoints\AddSubscriber;
use something\Mailchimp\Endpoints\GetList;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\MergeVar;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\SingleList;
use something\Mailchimp\Entities\Subscriber;
use something\Tests\Mailchimp\TestCase;

class AddSubscriberTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Endpoints\AddSubscriber::getHttpMethod()
	 */
	public function testGetHttpMethod()
	{

		$endpoint = new class extends AddSubscriber
		{
			protected function setList(string $listId): void
			{
				// TODO: Implement setList() method.
			}

		};
		$this->assertSame('POST', $endpoint->getHttpMethod());
	}


	public function testSetupSubscriber()
	{
		$this->markTestSkipped('Bad design');
		$endpoint = new class extends AddSubscriber
		{
			protected function setList(string $listId): void
			{
				$this->list = new SingleList();
				$this->list->setListId($listId);
				$mV = new MergeVars();
				$mV->addMergeVar(
					(new MergeVar())->setTag('LNAME')->setMergeId('LNAME')->setType('string')
				);
				$this->list->setMergeFields($mV);
				$this->list->setGroupFields(new Groups());

			}

			/**
			 * @inheritDoc
			 */
			public function getController() : MailchimpProxy
			{
				return new class(new MailchimpLists('food')) extends MailchimpProxy {


				};

			}


		};
		$this->assertSame('POST', $endpoint->getHttpMethod());
		$request = new Request();
		$listId = 'l1';
		$status = 'pending';
		$email = 'hiroy@hiroy.com';
		$mergeFields = [
			'LNAME' => 'Strange',
		];
		$groupFields = [];
		$request->setParams([
			'listId' => $listId,
			'status' => $status,
			'email' => $email,
			'mergeFields' => $mergeFields,
			'groupFields' => $groupFields,
		]);
		/** @var Subscriber $subscriber */
		$subscriber = $endpoint->setupSubscriber($request);
		$this->assertSame($listId, $subscriber->getListId() );
		$this->assertSame($email, $subscriber->getEmail() );
		$this->assertSame($status, $subscriber->getStatus() );
		$this->assertSame($mergeFields, $subscriber->getSubscribeMergeVars()->toArray() );
		$this->assertSame($groupFields, $subscriber->getSubscribeGroups()->toArray() );
	}
}
