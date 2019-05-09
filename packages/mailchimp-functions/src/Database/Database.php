<?php


namespace something\Mailchimp\Database;


use \calderawp\DB\Tables;
use Enormail\Account;
use WpDbTools\Type\TableSchema;

class Database
{
	/** @var Tables */
	protected $tables;

	/**
	 * @var Accounts
	 */
	protected $accountDbApi;

	/**
	 * @var Lists
	 */
	protected $listsDbApi;
	/**
	 * @var Table[]
	 */
	protected $queries;

	/**
	 * Database constructor.
	 *
	 * @param Tables $calderaDbTables
	 */
	public function __construct(Tables $calderaDbTables)
	{
		$this->tables = $calderaDbTables;
	}

	/**
	 * Get accounts table database abstraction
	 *
	 * @return Table
	 */
	public function getAccountsTable(): Table
	{
		return $this->getTable('accounts');
	}

	/**
	 * Get lists table database abstraction
	 *
	 * @return Table
	 */
	public function getListsTable(): Table
	{
		return $this->getTable('lists');

	}

	/**
	 * Get API for accounts - common queries
	 *
	 * @return Accounts
	 */
	public function getAccountDbApi() : Accounts
	{
		if( ! $this->accountDbApi ){
			$this->accountDbApi = new Accounts($this->getAccountsTable());
		}
		return $this->accountDbApi;

	}

	/**
	 * Get API for lists - common queries
	 *
	 * @return Lists
	 */
	public function getListsDbApi() : Lists
	{
		if( ! $this->listsDbApi ){
			$this->listsDbApi = new Lists($this->getListsTable());
		}
		return $this->listsDbApi;
	}

	/**
	 * @param $table
	 *
	 * @return Table
	 */
	protected function getTable($table): Table
	{
		if (empty($this->queries[ $table ])) {
			$this
				->tables
				->addTableSchema(
					$table,
					file_get_contents(__DIR__ . "/${table}.yml")
				);

			$this->tables
				->createTable($this->tables->getTableSchema($table));
			$this->queries[ $table ] = new Table(
				$this->tables->getDatabaseAdapter(),
				$this->tables->getTableSchema($table)
			);
		}
		return $this->queries[ $table ];
	}
}
