<?php

namespace something\Tests\Mailchimp\Entities;

use something\Mailchimp\Entities\Lists;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\TestCase;

class ListsTest extends TestCase
{

	/**
	 * @covers Lists::fromArray()
	 * @covers Lists::getLists()
	 */
	public function testFromArray()
	{
		$data = (array)$this->getListsData();
		$data = (array)$data[ 'lists' ];
		$lists = Lists::fromArray($data);
		$this->assertCount(1, $lists->getLists());
	}

	/**
	 * @covers Lists::__construct()
	 * @covers Lists::addList()
	 * @covers Lists::getLists()
	 */
	public function testGetLists()
	{
		$data = (array)$this->getListsData();
		$data = (array)$data[ 'lists' ][0];
		$lists = new Lists();
		$this->assertCount(0, $lists->getLists());
		$lists->addList(SingleList::fromArray($data));
		$this->assertCount(1, $lists->getLists());
		$this->assertEquals($data['id'], $lists->getList($data['id'])->getListId());
		$this->assertEquals($data['name'], $lists->getList($data['id'])->getName());
	}

	/**
	 * @covers Lists::toUiFieldConfig()
	 * @covers Lists::fromArray()
	 */
	public function testToUiConfig()
	{
		$data = $this->getListsData();
		$lists = Lists::fromArray($data['lists']);
		$listId = $data['lists'][0]->id;
		$this->assertEquals($listId, $lists->getList($listId)->getListId());
		$fields = $lists->toUiFieldConfig();
		$this->assertCount(1,$fields);
		$field = $fields[0];
		$this->assertEquals('select', $field['fieldType']);
		$this->assertCount(1,$field['options']);
		$this->assertTrue($field['required']);

		$this->assertEquals($listId, $field['options'][0]['value']);

	}
}


