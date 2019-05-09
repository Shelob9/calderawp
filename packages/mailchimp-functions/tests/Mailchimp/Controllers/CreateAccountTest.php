<?php

namespace something\Tests\Mailchimp\Controllers;

use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\CreateAccount;
use something\Mailchimp\Entities\Account;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class CreateAccountTest extends TestCase
{
	/**
	 * @covers \something\Mailchimp\Controllers\CreateAccount::__invoke()
	 */
	public function test__invoke()
	{

		$data = new \stdClass();
		$data->account_id = 'a11';
		$data->account_name ='s22';
		$httpClient = new MockClient();
		$mailchimpApi = new MailchimpLists('app','apikey',[],$httpClient);
		$httpClient->setNextResponseData($data);
		$controller = new class($mailchimpApi) extends CreateAccount{

			protected function saveAccount(Account $account): Account
			{
				return $account;
			}


		};

		$apiKey = 'foo';
		$result = $controller->__invoke($apiKey);
		$this->assertEquals( 's22',$result->getName() );
		$this->assertEquals($apiKey, $result->getApiKey() );
		$this->assertEquals('a11', $result->getMailChimpAccountId() );

	}
}
