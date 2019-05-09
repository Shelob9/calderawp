<?php


namespace something\Mailchimp\Controllers;


class GetSegments extends MailchimpProxy
{

	/**
	 * @param string $listId
	 *
	 * @return array
	 */
	public function __invoke(string $listId)
	{

		$body = $this->getMailchimp()->getSegments( $listId );
		return [
			'listId' => $listId,
			'segments' => isset($body->segments) ? $body->segments : []
		];
	}
}
