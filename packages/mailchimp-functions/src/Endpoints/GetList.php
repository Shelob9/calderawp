<?php


namespace something\Mailchimp\Endpoints;



use calderawp\caldera\restApi\Exception;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\interop\Contracts\TokenContract;
use Mailchimp\MailchimpAPIException;

class GetList extends MailchimpProxyEndpoint
{
	/** @inheritdoc */
	public function  getUri(): string
	{
		return self::BASE_URI . '/lists/(?P<listId>[\w-]+)';
	}

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'listId' => [
				'type' => 'string',
				'required' => true
			],
			'asUiConfig' => [
				'type' => 'boolean',
				'required' => false
			],
			'token' => [
				'type' => 'string',
				'required' => true
			]
		];
	}


	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function handleRequest(Request $request): Response
	{
		try{
			$list = $this->getController()->__invoke($request->getParam('listId') );
		}catch (MailchimpAPIException $e){
			return $this->exceptionToResponse($e);
		}

		if( $request->getParam('asUiConfig')){
			return (new \something\Mailchimp\Endpoints\Response())->setStatus(
				200)
				->setData( $list->toUiFieldConfig()
			);
		}

		return (new \something\Mailchimp\Endpoints\Response())->setStatus(200)->setData($list->toArray() );

	}


}
