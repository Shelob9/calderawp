<?php


namespace something\Mailchimp\Endpoints;


abstract class GetAccounts extends MailchimpProxyEndpoint
{
	/** @inheritdoc */
	public function getUri() : string {
		return self::BASE_URI . '/accounts';
	}

	public function getHttpMethod(): string
	{
		return 'GET';
	}

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'token' => [
				'type' => 'string',
				'required' => true
			]
		];

	}


}
