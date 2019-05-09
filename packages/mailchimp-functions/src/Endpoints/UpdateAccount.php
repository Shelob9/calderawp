<?php


namespace something\Mailchimp\Endpoints;
use calderawp\caldera\restApi\Exception;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;


class UpdateAccount extends MailchimpProxyEndpoint
{
	/** @inheritdoc */
	public function  getUri(): string
	{
		return self::BASE_URI . '/accounts';
	}

	public function getHttpMethod(): string
	{
		return 'POST';
	}

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'accountId' => [
				'type' => 'integer',
				'required' => true
			],
			'apiKey' => [
				'type' => 'string',
				'required' => false,
				'default' => '',
			],
			'name' => [
				'type' => 'string',
				'required' => false,
				'default' => '',
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
				->__invoke(
					$request->getParam('accountId'),
					$request->getParam('apiKey'),
					$request->getParam('name')
				);
		} catch (\Exception $e) {
			return $this->exceptionToResponse($e);
		}
		return (new \something\Mailchimp\Endpoints\Response())->setStatus(201)->setData($account->toArray() );

	}
}
