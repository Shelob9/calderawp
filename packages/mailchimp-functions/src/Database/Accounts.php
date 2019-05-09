<?php


namespace something\Mailchimp\Database;


use calderawp\DB\Time;
use something\Mailchimp\Entities\Account;

/**
 * Class Accounts
 *
 * Wrapper for accounts database table that returns Account entities
 */
class Accounts
{

	/**
	 * @var Table
	 */
	protected $table;

	public function __construct(Table $table)
	{
		$this->setTable($table);
	}

	public function create(Account$account):Account
	{
		$data = $account->toDbArray();
		try {
			$id = $this
				->getTable()
				->create($data);
			return  $this->getById($id);
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function update(Account $account){
		$data = $account->toDbArray();
		try {
			$id = $this
				->getTable()
				->update($account->getId(),$data);
			return $this->getById($id);
		} catch (\Exception $e) {
			throw $e;
		}
	}
	/**
	 * @return Table
	 */
	public function getTable(): Table
	{
		return $this->table;
	}

	/**
	 * @param Table $table
	 *
	 * @return Accounts
	 */
	public function setTable(Table $table): Accounts
	{
		$this->table = $table;
		return $this;
	}

	public function getAll(): array
	{
		return $this->prepareResults(
			$this->getTable()
				->selectAll()
		);

	}

	public function getById(int $accountId): ?Account
	{
		$results = $this->getTable()
			->findById($accountId);
		if( ! empty( $results ) ){
			return $this->prepareResult($results[0]);
		}
		return null;

	}

	public function getByMailChimpAccountId(string $mailChimpAccountId ) : array
	{
		return $this->prepareResults(
			$this->getTable()
				->findWhere('mailchimp_account_id', $mailChimpAccountId)
		);
	}

	public function findByApiKey(string $apiKey): array
	{
		return $this->prepareResults(
			$this->getTable()
				->findWhere('api_key', $apiKey)
		);
	}

	protected function prepareResults(array $results)
	{
		$prepared = [];
		if (!empty($results)) {
			foreach ($results as $result) {
				$prepared[] = $this->prepareResult($result);
			}
		}
		return $prepared;

	}

	protected function prepareResult(array $result): Account
	{

		$array =  array_merge([
			'name' => '',
			'api_key' => '',
			'updated' => date(Time::FORMAT ),
			'mailchimp_account_id' => '',
		],$result);
		return Account::fromArray($array);
	}


}
