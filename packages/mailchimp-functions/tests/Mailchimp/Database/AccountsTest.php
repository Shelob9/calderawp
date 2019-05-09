<?php

namespace something\Tests\Mailchimp\Database;

use something\Mailchimp\Database\Accounts;
use something\Mailchimp\Database\Table;
use something\Mailchimp\Entities\Account;
use something\Tests\Mailchimp\TestCase;

class AccountsTest extends TestCase
{

	public function testFindByApiKey()
	{
		$results = [$this->dbResult()];
		$table = \Mockery::mock(Table::class);
		$table
			->shouldReceive('findWhere')
			->andReturn( $results);

		$accounts = new Accounts($table);
		$this->assertEquals($table,$accounts->getTable());

		$resultEntities = [];
		foreach ($results as $result ){
			$resultEntities[] = Account::fromArray($result);
		}
		$this->assertEquals($resultEntities, $accounts->findByApiKey('8'));

	}

	public function testGetById()
	{
		$results = [$this->dbResult()];
		$table = \Mockery::mock(Table::class);
		$table
			->shouldReceive('findById')
			->andReturn( $results);

		$accounts = new Accounts($table);
		$this->assertEquals($table,$accounts->getTable());

		$this->assertEquals(Account::fromArray($results[0]), $accounts->getById('9'));

	}

	public function testGetByIdNoResults()
	{
		$results = [];
		$table = \Mockery::mock(Table::class);
		$table
			->shouldReceive('findById')
			->andReturn( $results);

		$accounts = new Accounts($table);
		$this->assertEquals($table,$accounts->getTable());

		$this->assertEquals(null, $accounts->getById('9'));

	}

	public function testGetAll()
	{
		$results = [$this->dbResult()];
		$table = \Mockery::mock(Table::class);
		$table
			->shouldReceive('selectAll')
			->andReturn( $results);

		$accounts = new Accounts($table);
		$this->assertEquals($table,$accounts->getTable());
		$resultEntities = [];
		foreach ($results as $result ){
			$resultEntities[] = Account::fromArray($result);
		}
		$this->assertEquals($resultEntities, $accounts->getAll());

	}

	public function testGetTable()
	{
		$table = \Mockery::mock(Table::class);
		$accounts = new Accounts($table);
		$this->assertEquals($table,$accounts->getTable());
	}

	public function testSetTable()
	{
		$table = \Mockery::mock(Table::class);
		$table2 = \Mockery::mock(Table::class);
		$accounts = new Accounts($table);
		$accounts->setTable($table2);
		$this->assertEquals($table2,$accounts->getTable());
	}

	public function testGetAllNoResults()
	{
		$table = \Mockery::mock(Table::class);
		$table = \Mockery::mock(Table::class);
		$table
			->shouldReceive('selectAll')
			->andReturn( []);
		$accounts = new Accounts($table);

		$this->assertEquals([], $accounts->getAll());
	}

	protected function dbResult():array
	{
		return [
			'id' => 7,
			'name' => 'list name',
			'api_key' => 'aaa aaa',
			'updated' => '1982-01-12 01:02:02',
			'mailchimp_account_id' => 'a1edf6111'
		];
	}
}
