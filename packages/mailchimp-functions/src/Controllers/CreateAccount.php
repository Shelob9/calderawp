<?php


namespace something\Mailchimp\Controllers;


use calderawp\CalderaMailChimp\CalderaMailChimp;
use something\Mailchimp\Entities\Account;

abstract class CreateAccount extends MailchimpProxy
{

	/**
	 * Find account in remote api via API key and save.
	 * @param string $apiKey
	 *
	 * @return Account
	 */
	public function __invoke(string $apiKey ): Account
	{
		$r = $this
			->getMailchimp()
			->getAccount();
		if( ! empty( $r ) ){

			$account =  Account::fromArray([
				'mailChimpAccountId' => $r->account_id,
				'name' => $r->account_name,
				'apiKey' => $apiKey
			]);

			return  $this->saveAccount($account);
		}

	}

	/**
	 * @param Account $account
	 *
	 * @return Account
	 */
	abstract protected function saveAccount(Account $account ): Account;

}
