<?php

namespace something\Tests\Mailchimp\Endpoints;

use calderawp\caldera\restApi\Request;
use Mailchimp\MailchimpLists;
use something\Mailchimp\Controllers\GetList;
use something\Mailchimp\Endpoints\GetLists;
use something\Mailchimp\Endpoints\Response;
use something\Mailchimp\Entities\Lists;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\MockClient;
use something\Tests\Mailchimp\TestCase;

class GetListsTest extends TestCase
{
	/** @covers \something\Mailchimp\Endpoints\GetLists::respondForUiField */
	public function testRespondForUiField()
	{

		$httpClient = new MockClient();
		$MailchimpApi = new MailchimpLists('app', 'apikey', [], $httpClient);
		$MailchimpApi->setClient($httpClient);
		$controller = new class ($MailchimpApi) extends \something\Mailchimp\Controllers\GetLists
		{
			protected function getSavedLists(int $accountId): array
			{
				return [
					(new SingleList())->setAccountId($accountId),
					(new SingleList())->setAccountId($accountId)->setId(2),
				];
			}

		};
		$endpoint = new GetLists();
		$endpoint->setController($controller);

		$data = (array)$this->getListsData();
		$data = (array)$data[ 'lists' ];
		$lists = Lists::fromArray($data);
		$response = $endpoint->respondForUiField($lists);

		$fieldConfig = $response->getData()[ 0 ];
		$this->assertEquals([
			[
				'value' => '45907f0c59',
				'label' => 'Future Capable',

			],
		],
			$fieldConfig[ 'options' ]
		);
		$this->assertEquals('select',
			$fieldConfig[ 'fieldType' ]
		);
		$this->assertTrue($fieldConfig['required']);

	}

	public function testGetToken()
	{
		$request = new Request();
		$request->setParam( 'token', 'toons');
		$endpoint = new GetLists();
		$this->assertEquals('toons', $endpoint->getToken($request));
	}
}


