<?php


namespace something\Tests\Mailchimp;


use Mailchimp\http\MailchimpHttpClientInterface;
use Mailchimp\Tests\MailchimpTestHttpClient;
use Mailchimp\Tests\MailchimpTestHttpResponse;

class MockClient implements MailchimpHttpClientInterface
{
	protected $responseData;

	public function setNextResponseData( $responseData): MockClient
	{
		$this->responseData = $responseData;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function handleRequest($method, $uri = '', $options = [], $parameters = [], $returnAssoc = false)
	{
		if (!empty($parameters)) {
			if ($method == 'GET') {
				// Send parameters as query string parameters.
				$options[ 'query' ] = $parameters;
			} else {
				// Send parameters as JSON in request body.
				$options[ 'json' ] = (object)$parameters;
			}
		}

		$this->method = $method;
		$this->uri = $uri;
		$this->options = $options;

		return $this->responseData;
	}

}
