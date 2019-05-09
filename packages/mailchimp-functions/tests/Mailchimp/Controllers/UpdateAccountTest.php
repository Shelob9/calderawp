<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\UpdateAccount;
use something\Mailchimp\Entities\Account;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class UpdateAccountTest extends TestCase
{

	public function test__invoke()
	{
		$data = new \stdClass();
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$controller = new class($mailchimpApi) extends UpdateAccount {
			protected function findAccountById(int $accountId): Account
			{
				return (new Account())->setId($accountId);
			}

			protected function saveAccount(Account $account): Account
			{
				return $account;
			}

		};
		$apiKey = 'a1';
		$accountId = 2;
		$name = 'barns';
		$result = $controller->__invoke($accountId,$apiKey,$name);
		$this->assertEquals($apiKey,$result->getApiKey());
		$this->assertEquals($accountId,$result->getId());
		$this->assertEquals($name,$result->getName());
	}
}
