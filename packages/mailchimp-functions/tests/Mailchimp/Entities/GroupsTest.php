<?php

namespace something\Tests\Mailchimp\Entities;
use something\Tests\Mailchimp\TestCase;

use something\Mailchimp\Entities\Group;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Exception;

class GroupsTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\Groups::getGroups()
	 * @covers \something\Mailchimp\Entities\Groups::addGroup()
	 */
	public function testFromArray()
	{
		$data = (array)$this->getGroupsData();

		$id1 = $data[ 0 ]->id;
		$id2 = $data[ 1 ]->id;
		$id3 = '444';
		$group3 = (new Group())->setId($id3)->setTitle('t3');
		$data[] = $group3->toArray();

		$groups = Groups::fromArray($data);

		$this->assertInstanceOf(Group::class, $groups->getGroup($id1));
		$this->assertInstanceOf(Group::class, $groups->getGroup($id2));
		$this->assertInstanceOf(Group::class, $groups->getGroup($id3));
		$this->assertEquals($id1, $groups->getGroup($id1)->getId());
		$this->assertEquals($id2, $groups->getGroup($id2)->getId());
		$this->assertEquals($id3, $groups->getGroup($id3)->getId());
		$this->assertEquals('t3', $groups->getGroup($id3)->getTitle());

	}
	/**
	 * @covers \something\Mailchimp\Entities\Groups::getGroups()
	 * @covers \something\Mailchimp\Entities\Groups::addGroup()
	 */
	public function testGetGroups()
	{

		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$groups = new Groups();
		$groups->addGroup($group);
		$this->expectException(Exception::class);
		$groups->getGroup('1111');

	}

	/**
	 * @covers \something\Mailchimp\Entities\Groups::getGroups()
	 * @covers \something\Mailchimp\Entities\Groups::addGroup()
	 */
	public function testAddGetGroup()
	{
		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$groups = new Groups();
		$groups->addGroup($group);
		$this->assertEquals($group, $groups->getGroup($group->getId()));


	}
}
