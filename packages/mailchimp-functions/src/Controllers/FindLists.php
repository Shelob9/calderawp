<?php


namespace something\Mailchimp\Controllers;


use something\Mailchimp\Entities\SingleList;

class FindLists extends MailchimpProxy
{

	public function __invoke(int $accountId) : array
	{
		$r = $this->getMailchimp()->getLists();
		$lists = isset( $r->lists ) ? (array) $r->lists : [];
		$prepared = [];
		if( $lists ){
			foreach ( $lists as $list ){
				$list = SingleList::fromArray((array)$list);
				$list->setAccountId($accountId);
				$prepared[] = $list;
			}
		}
		return $prepared;

	}
}
