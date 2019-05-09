<?php

namespace something\Tests\Mailchimp\Entities;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\SubscribeGroups;

class SubscribeGroupsTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroups()
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::toArray()
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroupJoin()
	 */
	public function testSetGroupJoin()
	{
		$data = (array)$this->getGroupsData();

		$id1 = $data[ 0 ]->id;
		$id2 = $data[ 1 ]->id;

		$groups = Groups::fromArray($data);
		$subscribeGroups = new SubscribeGroups();
		$subscribeGroups->setGroups($groups);
		$subscribeGroups->setGroupJoin($id2, true);
		$subscribeGroups->setGroupJoin($id1, false);
		$array = $subscribeGroups->toArray();
		$this->assertTrue($array[ $id2 ]);

	}

	/**
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroupJoins()
	 */
	public function testSetGroupJoins()
	{
		$data = (array)$this->getGroupsData();

		$id1 = $data[ 0 ]->id;
		$id2 = $data[ 1 ]->id;


		$groups = Groups::fromArray($data);

		$joins = [
			$id1 => false,
			$id2 => true,
		];

		$subscribeGroups = new SubscribeGroups();
		$subscribeGroups->setGroups($groups);
		$subscribeGroups->setGroupsJoins($joins);
		$array = $subscribeGroups->toArray();
		$this->assertTrue($array[ $id2 ]);
	}

}
