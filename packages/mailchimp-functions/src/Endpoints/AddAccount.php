<?php


namespace something\Mailchimp\Endpoints;


use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;

class AddAccount extends MailchimpProxyEndpoint
{

	/** @inheritdoc */
	public function getUri() : string {
		return self::BASE_URI . '/accounts';
	}

	public function getHttpMethod(): string
	{
		return 'PUT';
	}

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'apiKey' => [
				'type' => 'string',
				'required' => true
			],
			'token' => [
				'type' => 'string',
				'required' => true
			]
		];

	}
	/**
	 * @inheritDoc
	 */
	public function handleRequest(Request $request): Response
	{
		try {
			$account = $this->getController()
				->__invoke($request->getParam('apiKey'));
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return (new \something\Mailchimp\Endpoints\Response())->setStatus(200)->setData($account->toArray() );

	}

}
