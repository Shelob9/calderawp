<?php


namespace something\Mailchimp\Endpoints;


abstract class UpdateSubscriber extends AddSubscriber
{
	/**
	 * @inheritDoc
	 */
	public function getHttpMethod(): string
	{
		return 'PUT';
	}

}
