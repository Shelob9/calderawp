<?php


namespace something\Mailchimp\Controllers;


use something\Mailchimp\Entities\Account;

abstract class UpdateAccount extends MailchimpProxy
{
	/**
	 * @param int $accountId
	 * @param null|string $apiKey
	 * @param null|string $name
	 *
	 * @return Account
	 * @throws \Exception
	 */
	public function __invoke(int $accountId, ?string $apiKey = null, ?string $name = null ) : Account
	{
			try {
				$account = $this->findAccountById($accountId);
				if(! empty( $apiKey) ){
					$account->setApiKey($apiKey);

				}
				if( ! empty($name) ){
					$account->setName($name);
				}
			} catch (\Exception $e) {
				throw  $e;
			}
			try{
				$account = $this->saveAccount($account);
			}catch (\Exception $e ){
				throw $e;
			}

			return $account;


	}

	/**
	 * @param int $accountId
	 *
	 * @return Account
	 */
	abstract protected function findAccountById(int $accountId ): Account;

	/**
	 * @param Account $account
	 *
	 * @return Account
	 */
	abstract protected function saveAccount(Account $account ): Account;
}
