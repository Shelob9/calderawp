<?php


namespace something\Mailchimp\Database;


use something\Mailchimp\Entities\Account;
use something\Mailchimp\Entities\SingleList;

/**
 * Class Lists
 *
 * Wrapper for lists database table that returns List entities
 */
class Lists
{
	/**
	 * @var Table
	 */
	protected $table;

	public function __construct(Table $table)
	{
		$this->setTable($table);
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
	 * @return Lists
	 */
	public function setTable(Table $table): Lists
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * Save a new list
	 *
	 * @param array $data
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function create(array $data): SingleList
	{
		try {
			/** @var int $result */
			$result = $this
				->getTable()
				->create($data);
			return $this->findById($result);
		} catch (\Exception $e) {
			throw  $e;
		}
	}

	/**
	 * Update a list
	 *
	 * @param SingleList $list
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function update(SingleList $list): SingleList
	{
		try {
			/** @var int $result */

            $result = $this
				->getTable()
				->update($list->getId(), $list->toDbArray());
			return $this->findById($list->getId());
		} catch (\Exception $e) {
			throw  $e;
		}
	}

	/**
	 * Find list by ID
	 *
	 * @param int $id Database primary identifier
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function findById(int $id): SingleList
	{
		try {
			$result = $this
				->getTable()
				->findById($id);
			return $this->prepareResult($result[ 0 ]);
		} catch (\Exception $e) {
			throw  $e;
		}
	}

	/**
	 * Find list by account ID
	 *
	 * @param int $accountId Mailchimp list Id
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function findByAccountId(int $accountId): array
	{
		try {
			$results = $this
				->getTable()
				->findWhere('account_id', $accountId );
			return $this->prepareResults($results);
		} catch (\Exception $e) {
			throw  $e;
		}
	}

	/**
	 * Find list by list ID
	 *
	 * @param string $listId Mailchimp list Id
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function findByListId(string $listId): array
	{
		try {
			$results = $this
				->getTable()
				->findWhere('list_id', $listId);;
			return $this->prepareResults($results);
		} catch (\Exception $e) {
			throw  $e;
		}
	}

	/**
	 * @param array $results
	 *
	 * @return array
	 */
	protected function prepareResults(array $results): array
	{
		$prepared = [];
		if (!empty($results)) {
			foreach ($results as $result) {
				$prepared[] = $this->prepareResult($result);
			}
		}
		return $prepared;
	}

	/**
	 * @param array $result
	 *
	 * @return SingleList
	 */
	protected function prepareResult(array $result): SingleList
	{
		return SingleList::fromDbResult($result);
	}
}
