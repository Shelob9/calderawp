<?php


namespace something\Mailchimp\Endpoints;
use calderawp\caldera\restApi\Exception;
use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;
use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\MailchimpProxy;


abstract class MailchimpProxyEndpoint implements EndpointContract
{

	use ProvidesRestEndpoint;

	const BASE_URI = '/messages/mailchimp/v1';
	/**
	 * @var MailchimpProxy
	 */
	protected $controller;

	/**
	 * @return MailchimpProxy
	 */
	public function getController(): MailchimpProxy
	{
		return $this->controller;
	}

	/**
	 * @param MailchimpProxy $controller
	 *
	 * @return MailchimpProxyEndpoint
	 */
	public function setController(MailchimpProxy $controller): MailchimpProxyEndpoint
	{
		$this->controller = $controller;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function authorizeRequest(Request $request): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function getToken(Request $request): string
	{
		return ! empty($request->getParam('token') )
			? $request->getParam( 'token')
			: '';
	}

	protected function exceptionToResponse(\Exception $exception) : Response
	{
		return (new Response() )->setStatus($exception->getCode())->setData(['message' => $exception->getMessage()]);
	}

	protected function getMailChimpClient()
	{
		return new MailchimpLists($_ENV['MAILCHIMP_KEY']);//@????
	}
}
