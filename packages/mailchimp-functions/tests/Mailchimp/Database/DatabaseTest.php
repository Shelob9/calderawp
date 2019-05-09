<?php

namespace something\Tests\Mailchimp\Database;

use calderawp\DB\Tables;
use something\Mailchimp\Database\Accounts;
use something\Mailchimp\Database\Database;
use something\Mailchimp\Database\Lists;
use something\Mailchimp\Database\Table;
use something\Tests\Mailchimp\TestCase;

class DatabaseTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Database\Database::getListsDbApi()
	 */
	public function testGetListsDbApi()
	{
		$database = $this->getMockDatabase();
		$this->assertInstanceOf(Lists::class, $database->getListsDbApi());
	}

	/**
	 * @covers \something\Mailchimp\Database\Database::getAccountDbApi()
	 */
	public function testGetAccountDbApi()
	{
		$database = $this->getMockDatabase();
		$this->assertInstanceOf(Accounts::class, $database->getAccountDbApi());
	}

	/**
	 * @covers \something\Mailchimp\Database\Database::getListsTable()
	 */
	public function testGetAccountsTable()
	{
		$database = $this->getMockDatabase();
		$this->assertInstanceOf(Table::class, $database->getListsTable());
	}

	/**
	 * @covers \something\Mailchimp\Database\Database::getAccountsTable()
	 */
	public function testGetListsTable()
	{
		$database = $this->getMockDatabase();
		$this->assertInstanceOf(Table::class, $database->getAccountsTable());
	}

	/**
	 * @return Database|__anonymous@850
	 */
	protected function getMockDatabase()
	{
		$tables = \Mockery::mock(Tables::class);

		$database = new class($tables) extends Database
		{
			protected function getTable($table): Table
			{
				$table = \Mockery::mock(Table::class);
				return $table;
			}
		};
		return $database;
	}
}
