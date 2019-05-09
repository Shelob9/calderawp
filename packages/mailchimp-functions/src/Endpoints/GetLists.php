<?php


namespace something\Mailchimp\Endpoints;



use calderawp\caldera\restApi\Exception;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\interop\Contracts\TokenContract;
use Mailchimp\MailchimpAPIException;
use something\Mailchimp\Entities\Lists;


class GetLists extends MailchimpProxyEndpoint
{

	/** @inheritdoc */
	public function  getUri(): string
	{
		return self::BASE_URI . '/lists';
	}

	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'accountId' => [
				'type' => 'integer',
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
			$lists = $this->getController()->__invoke($request->getParam('accountId') );
		}catch (MailchimpAPIException $e){
			return $this->exceptionToResponse(new Exception($e->getMessage(), $e->getCode(), $e));
		}


		if( $request->getParam('asUiConfig')){
			return $this->respondForUiField(Lists::fromArray($lists));


		}
		$responseData = [];
		if( ! empty( $lists ) ){
			foreach ( $lists as $list ){
				$responseData[] = $list->toArray();
			}
		}
		return (new \something\Mailchimp\Endpoints\Response())->setStatus(200 )->setData($responseData );

	}

	/**
	 * @param Lists $lists
	 *
	 * @return \calderawp\interop\Contracts\HttpResponseContract
	 */
	public function respondForUiField(Lists $lists): \calderawp\interop\Contracts\HttpResponseContract
	{

		return (new \something\Mailchimp\Endpoints\Response())
			->setStatus(200)
			->setData($lists->toUiFieldConfig());
	}

}
