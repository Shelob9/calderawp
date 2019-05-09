<?php


namespace something\Mailchimp\Controllers;


use Mailchimp\http\MailchimpHttpClientInterface;
use Mailchimp\MailchimpLists;
use something\Mailchimp\Entities\Lists;

abstract class GetLists extends MailchimpProxy
{



	public function __invoke(int $accountId ) : array
	{

		try{
			$lists = $this->getSavedLists($accountId);
		}catch (\Exception $e ){
			throw $e;
		}

		return $lists;
	}

	abstract protected function getSavedLists(int $accountId) : array ;

}
