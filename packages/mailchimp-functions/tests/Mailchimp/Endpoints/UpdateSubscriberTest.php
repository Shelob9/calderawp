<?php

namespace something\Tests\Mailchimp\Endpoints;

use something\Mailchimp\Endpoints\UpdateSubscriber;
use something\Tests\Mailchimp\TestCase;

class UpdateSubscriberTest extends TestCase
{
	/**
	 * @covers \something\Mailchimp\Endpoints\UpdateSubscriber::getHttpMethod()
	 */
	public function testGetHttpMethod()
	{

		$endpoint = new class extends UpdateSubscriber
		{
			protected function setList(string $listId): void
			{
				// TODO: Implement setList() method.
			}

		};
		$this->assertSame('PUT', $endpoint->getHttpMethod());
	}
}
