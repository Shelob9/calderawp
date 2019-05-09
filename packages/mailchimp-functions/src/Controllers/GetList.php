<?php


namespace something\Mailchimp\Controllers;



use Mailchimp\MailchimpAPIException;
use something\Mailchimp\Entities\SingleList;
use something\Mailchimp\Exception;

abstract class GetList extends MailchimpProxy
{

	/**
	 * @param string $id
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function __invoke(int $id)
	{
		try {
			$list = $this->findById($id);
			return $list;
		} catch (\Exception $e) {
			throw  $e;
		}


	}
	/**
	 * @param int $accountId
	 *
	 * @return SingleList
	 */
	abstract protected function findById(int $accountId ): SingleList;
}
