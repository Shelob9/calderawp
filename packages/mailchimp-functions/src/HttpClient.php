<?php


namespace something\Mailchimp;

use Mailchimp\http\MailchimpHttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Mailchimp\MailchimpAPIException;
use Mailchimp\http\MailchimpGuzzleHttpClient;

class HttpClient extends MailchimpGuzzleHttpClient
{

	/**
	 * The GuzzleHttp client.
	 *
	 * @var Client $client
	 */
	protected $guzzle;

	public function __construct(array $config = [])
	{
		$this->guzzle = new Client($config);
	}

	/**
	 * @return Client
	 */
	public function getGuzzle(): Client
	{
		return $this->guzzle;
	}

	/**
	 * @param Client $guzzle
	 *
	 * @return HttpClient
	 */
	public function setGuzzle(Client $guzzle): HttpClient
	{
		$this->guzzle = $guzzle;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function handleRequest($method, $uri = '', $options = [], $parameters = [], $returnAssoc = FALSE) {
		if (!empty($parameters)) {
			if ($method == 'GET') {
				// Send parameters as query string parameters.
				$options['query'] = $parameters;
			}
			else {
				// Send parameters as JSON in request body.
				$options['json'] = (object) $parameters;
			}
		}

		try {
			$response = $this->getGuzzle()->request($method, $uri, $options);
			$data = json_decode($response->getBody(), $returnAssoc);

			return $data;
		}
		catch (RequestException $e) {
			$response = $e->getResponse();
			if (!empty($response)) {
				$message = $e->getResponse()->getBody();
			}
			else {
				$message = $e->getMessage();
			}

			throw new MailchimpAPIException($message, $e->getCode(), $e);
		}
	}


}
