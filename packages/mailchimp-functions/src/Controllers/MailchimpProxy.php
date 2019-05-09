<?php


namespace something\Mailchimp;

namespace something\Mailchimp\Controllers;

use calderawp\CalderaMailChimp\CalderaMailChimp;
use Mailchimp\MailchimpLists;

abstract class MailchimpProxy
{
	/**
	 * @var MailchimpLists
	 */
	private $mailchimp;


	public function __construct(MailchimpLists $mailchimp)
	{
		$this->mailchimp = $mailchimp;
	}

	/**
	 * @return MailchimpLists
	 */
	public function getMailchimp()
	{
		return $this->mailchimp;
	}

	/**
	 * @param MailchimpLists $mailchimp
	 *
	 * @return MailchimpProxy
	 */
	public function setMailchimp(MailchimpLists $mailchimp) : MailchimpProxy
	{
		$this->mailchimp = $mailchimp;
		return $this;
	}


}
