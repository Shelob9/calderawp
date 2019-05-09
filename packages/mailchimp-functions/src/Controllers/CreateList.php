<?php


namespace something\Mailchimp\Controllers;


use something\Mailchimp\Entities\SingleList;

abstract class CreateList extends MailchimpProxy
{

	/**
	 * @param string $listId
	 * @param int $accountId
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function __invoke(
		string $listId,
		int $accountId
	) : SingleList
	{
		$r = $this->getMailchimp()
			->getList($listId);
		if( ! empty( $r ) ){
			try {
				$data = [
					'accountId' => $accountId,
					'listId' => $listId,

				];
				$groupsController = new FindGroups($this->getMailchimp());

				try {
					$groups = $groupsController->__invoke($listId);
					$data[ 'groupFields' ] = $groups;
				} catch (\Exception $e) {
				}
				$mergeFieldController = new FindMergeFields($this->getMailchimp());

				try {
					$mergeFields = $mergeFieldController->__invoke($listId);
					$data[ 'mergeFields' ] = $mergeFields;
				} catch (\Exception $e) {
					throw  $e;
				}
				$list = $this->create($data);

				return $list;
			} catch (\Exception $e) {
				throw  $e;
			}
		}



	}

	/**
	 * @param array $data
	 *
	 * @return SingleList
	 */
	abstract protected function create(array $data ): SingleList;
}
