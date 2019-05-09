<?php

namespace something\Tests\Mailchimp\Entities;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\Group;

class GroupTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\Group::getId()
	 * @covers \something\Mailchimp\Entities\Group::getGroupId()
	 * @covers \something\Mailchimp\Entities\Group::getTitle()
	 * @covers \something\Mailchimp\Entities\Group::getType()
	 * @covers \something\Mailchimp\Entities\Group::getListId()
	 * @covers \something\Mailchimp\Entities\Group::fromArray()
	 */
	public function testFromArray(){
		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$this->assertEquals( $data['id'], $group->getId() );
		$this->assertEquals( $data['title'], $group->getTitle() );
		$this->assertEquals( $data['type'], $group->getType() );
		$this->assertEquals( $data['list_id'], $group->getListId() );

	}

	/**
	 * @covers \something\Mailchimp\Entities\Group::getId()
	 * @covers \something\Mailchimp\Entities\Group::getGroupId()
	 * @covers \something\Mailchimp\Entities\Group::setGroupId()
	 * @covers \something\Mailchimp\Entities\Group::getGroupId()
	 * @covers \something\Mailchimp\Entities\Group::fromArray()
	 */
	public function testSetGroupId(){
		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$this->assertEquals( $data['id'], $group->getId() );
		$this->assertEquals( $data['id'], $group->getGroupId() );


	}

	/**
	 * @covers \something\Mailchimp\Entities\Group::toArray()
	 * @covers \something\Mailchimp\Entities\Group::fromArray()
	 */
	public function testToArray()
	{
		$data = (array)$this->getGroupsData()[0];
		$group =  Group::fromArray($data);
		$array = $group->toArray();
		$this->assertEquals( $data['id'], $array['groupId'] );
		$this->assertEquals( $data['title'], $array['title'] );
		$this->assertEquals( $data['type'], $array['type'] );
		$this->assertEquals( $data['list_id'], $array['listId'] );
	}

	/**
	 * @covers \something\Mailchimp\Entities\Group::setShouldJoin()
	 * @covers \something\Mailchimp\Entities\Group::getShouldJoin()
	 */
	public function testShouldJoin()
	{
		$group =  Group::fromArray(['join' => false ]);
		$this->assertFalse($group->getShouldJoin());
		$group->setShouldJoin(true );
		$this->assertTrue($group->getShouldJoin());

		$group = new Group();
		$group->setShouldJoin(true );
		$this->assertTrue($group->getShouldJoin());
		$group->setShouldJoin(false );

		$this->assertFalse($group->getShouldJoin());

	}
}
