<?php

namespace something\Tests\Mailchimp\Entities;

use something\Mailchimp\Entities\Account;
use something\Tests\Mailchimp\TestCase;

class AccountTest extends TestCase
{

	public function testGetName()
	{
		$account = new Account();
		$account->setName('bags');
		$this->assertEquals('bags', $account->getName() );
	}

	public function testGetUpdated()
	{
		$account = new Account();
		$this->assertInstanceOf(\DateTimeImmutable::class, $account->getUpdated() );
	}

	public function testGetMailChimpAccountId()
	{
		$account = new Account();
		$account->setMailChimpAccountId('a7');
		$this->assertEquals('a7', $account->getMailChimpAccountId() );
	}

	public function testSetUpdatedWithDateTime()
	{
		$datetime = new \DateTime();
		$newDate = $datetime->createFromFormat('d/m/Y', '23/05/2013');
		$account = new Account();
		$account->setUpdated($newDate);
		$this->assertEquals($newDate,$account->getUpdated());
	}

	public function testSetUpdatedWithMySqlString()
	{
		$timestamp = '1982-01-12 01:02:02';
		$account = new Account();
		$account->setUpdated($timestamp);
		$time = strtotime($timestamp);
		$this->assertEquals($time,$account->getUpdated()->getTimestamp());
	}

	public function testSetUpdatedWithInteger()
	{

		$time = strtotime('June 1st, 2019');
		$account = new Account();
		$account->setUpdated($time);
		$this->assertEquals($time,$account->getUpdated()->getTimestamp());
	}



	public function testGetApiKey()
	{
		$account = new Account();
		$account->setApiKey('arm1');
		$this->assertEquals('arm1', $account->getApiKey());

	}

	public function testGetId()
	{
		$account = new Account();
		$account->setId(7);
		$this->assertEquals(7, $account->getId());
	}

	public function testFromArrayDbResultFormat()
	{
		$data = [
			'id' => 7,
			'name' => 'list name',
			'api_key' => 'aaa aaa',
			'updated' => '1982-01-12 01:02:02',
			'mailchimp_account_id' => 'a1edf6111'
		];
		/** @var Account $account */
		$account = Account::fromArray($data);
		$this->assertEquals($data['id'], $account->getId());
		$this->assertEquals($data['name'],$account->getName());
		$this->assertEquals($data['api_key'],$account->getApiKey());
		$this->assertEquals($data['mailchimp_account_id'],$account->getMailChimpAccountId());
		$this->assertEquals(strtotime($data['updated']),$account->getUpdated()->getTimestamp());
	}

	public function testFromArray()
	{
		$data = [
			'id' => 7,
			'name' => 'list name',
			'apiKey' => 'aaa aaa',
			'updated' => '1982-01-12 01:02:02',
			'mailChimpAccountId' => 'a1edf6111'
		];
		/** @var Account $account */
		$account = Account::fromArray($data);
		$this->assertEquals($data['id'], $account->getId());
		$this->assertEquals($data['name'],$account->getName());
		$this->assertEquals($data['apiKey'],$account->getApiKey());
		$this->assertEquals($data['mailChimpAccountId'],$account->getMailChimpAccountId());
		$this->assertEquals(strtotime($data['updated']),$account->getUpdated()->getTimestamp());
	}

	public function testToDbArray()
	{
		$data = [
			'id' => 7,
			'name' => 'list name',
			'apiKey' => 'aaa aaa',
			'updated' => '1982-01-12 01:02:02',
			'mailChimpAccountId' => 'a1edf6111'
		];
		/** @var Account $account */
		$account = Account::fromArray($data);
		$dbData = $account->toDbArray();
		$this->assertEquals($dbData['id'], $account->getId());
		$this->assertEquals($dbData['name'],$account->getName());
		$this->assertEquals($dbData['api_key'],$account->getApiKey());
		$this->assertEquals($dbData['mailchimp_account_id'],$account->getMailChimpAccountId());
		$this->assertEquals(strtotime($dbData['updated']),$account->getUpdated()->getTimestamp());
	}
}
