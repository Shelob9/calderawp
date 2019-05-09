<?php


namespace something\Mailchimp\Controllers;


use something\Mailchimp\Entities\Group;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\SingleList;

abstract class UpdateList extends MailchimpProxy
{

	/**
	 * @param int $id
	 * @param array|null $groupFields
	 * @param array|null $mergeFields
	 * @param array|null $segments
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function __invoke(
		int $id,
		?array $groupFields,
		?array $mergeFields,
		?array $segments
	): SingleList {
		try {
			$list = $this->findById($id);
			if( $groupFields ){
				$list->setGroupFields(Groups::fromArray($groupFields));
			}
			if( $mergeFields ) {
				$list->setMergeFields(MergeVars::fromArray($mergeFields));
			}

			try {
				$list = $this->update($list);
			} catch (\Exception $e) {
				throw  $e;

			}
			return $list;
		} catch (\Exception $e) {
			throw  $e;
		}


	}


	abstract protected function findById(int $id): SingleList;
	abstract protected function update(SingleList $data): SingleList;
}
