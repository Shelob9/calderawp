<?php

namespace something\Tests\Mailchimp\Entities;

use something\Mailchimp\Entities\Group;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\MergeVar;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\SingleList;
use something\Tests\Mailchimp\TestCase;

class SingleListTest extends TestCase
{


	/**
	 * @covers \something\Mailchimp\Entities\SingleList::setGroupFields()
	 * @covers \something\Mailchimp\Entities\SingleList::getGroupFields()
	 * @covers \something\Mailchimp\Entities\SingleList::setMergeFields()
	 * @covers \something\Mailchimp\Entities\SingleList::getMergeFields()
	 * @covers \something\Mailchimp\Entities\SingleList::fromArray()
	 */
	public function testFromArray()
	{
		$data = (array)$this->getMergeFieldsData();

		$mergeFields = MergeVars::fromArray($data);
		$groups = new Groups();
		/** @var SingleList $list */
		$list =  SingleList::fromArray([
			'mergeFields' => $mergeFields,
			'groupFields' => $groups
		]);
		$this->assertEquals($groups,$list->getGroupFields() );
		$this->assertEquals($mergeFields,$list->getMergeFields() );


	}


	/**
	 * @covers \something\Mailchimp\Entities\SingleList::fromArray()
	 * @covers \something\Mailchimp\Entities\SingleList::getName()
	 * @covers \something\Mailchimp\Entities\SingleList::setName()
	 */
	public function testGetName()
	{
		$data = (array)$this->getListsData();
		$data = (array)$data['lists'][0];
		$list = SingleList::fromArray($data);
		$this->assertEquals($data['name'],$list->getName());
		$list->setName( 'Trover');
		$this->assertEquals('Trover',$list->getName());

	}



	/**
	 * @covers \something\Mailchimp\Entities\SingleList::setGroupFields()
	 * @covers \something\Mailchimp\Entities\SingleList::getGroupFields()
	 * @covers \something\Mailchimp\Entities\SingleList::setMergeFields()
	 * @covers \something\Mailchimp\Entities\SingleList::getMergeFields()
	 * @covers \something\Mailchimp\Entities\SingleList::fromArray()
	 */
	public function testFromArrayofArrays()
	{
		$data = (array)$this->getMergeFieldsData();
		$mergeFields = MergeVars::fromArray($data);

		$data = (array)$this->getGroupsData();
		$groups= Groups::fromArray($data);

		$list =  SingleList::fromArray([
			'mergeFields' => $mergeFields->toArray()['mergeVars'],
			'groupFields' => $groups
		]);
		$this->assertEquals($groups,$list->getGroupFields() );
		$this->assertEquals($mergeFields,$list->getMergeFields() );
	}

	/**
	 * @covers \something\Mailchimp\Entities\SingleList::toUiFieldConfig()
	 * @covers \something\Mailchimp\Entities\MergeVar::toUiFieldConfig()
	 */
	public function testToUiFieldConfig()
	{
		$data = (array)$this->getMergeFieldsData();
		$mergeFields = MergeVars::fromArray($data);
		$list =  SingleList::fromArray([
			'mergeFields' => $mergeFields->toArray()['mergeVars'],
		]);
		$this->assertCount(1 + count($mergeFields->toUiFieldConfig()), $list->toUiFieldConfig());
		$found = false;
		foreach ($list->toUiFieldConfig() as $field ){
			if( $list->getEmailFieldId() == $field['fieldId']){
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
	}

	public function testFromDatabaseResult(){
		$result = [
			'account_id' => 5,
			'list_id' => 'afsdkj1',
			'group_fields' => serialize([]),
			'merge_fields' => serialize([]),
			'segments' => serialize([]),
			'updated' => null,
		];
		/** @var SingleList $list */
		$list = SingleList::fromDbResult($result);
		$this->assertEquals(5, $list->getAccountId());
		$this->assertEquals('afsdkj1', $list->getListId());
		$this->assertEquals(Groups::fromArray([]), $list->getGroupFields());
		$this->assertEquals([], $list->getSegments());
	}

	public function testToDbData()
	{
		$data = (array)$this->getMergeFieldsData();

		$mergeFields = MergeVars::fromArray($data);
		$groups = Groups::fromArray(([Group::fromArray(['id' => 7, ])]));
		/** @var SingleList $list */
		$list =  SingleList::fromArray([
			'accountId' => 1,
			'mergeFields' => $mergeFields,
			'groupFields' => $groups
		]);
		$list->setId(7);
		$list->setListId('a1');
		$dbData = $list->toDbArray();
		$this->assertEquals('a1', $dbData['list_id' ] );
		$this->assertEquals( $groups->toArray(), $dbData[ 'group_fields'] );
		$this->assertEquals( $mergeFields->toArray(), $dbData[ 'merge_fields'] );
		$this->assertEquals( [], $dbData[ 'segments'] );
		$this->assertIsString(  $dbData[ 'updated'] );
	}

	public function testSetUpdatedWithDateTime()
	{
		$datetime = new \DateTime();
		$newDate = $datetime->createFromFormat('d/m/Y', '23/05/2013');
		$account = new SingleList();
		$account->setUpdated($newDate);
		$this->assertEquals($newDate,$account->getUpdated());
	}

	public function testSetUpdatedWithMySqlString()
	{
		$timestamp = '1982-01-12 01:02:02';
		$list = new SingleList();
		$list->setUpdated($timestamp);
		$time = strtotime($timestamp);
		$this->assertEquals($time,$list->getUpdated()->getTimestamp());
	}

	public function testSetUpdatedWithInteger()
	{
		$time = strtotime('June 1st, 2019');
		$account = new SingleList();
		$account->setUpdated($time);
		$this->assertEquals($time,$account->getUpdated()->getTimestamp());
	}


	public function testHasMergeFields()
	{
		$list = new SingleList();
		$this->assertFalse($list->hasMergeFields());
		$data = (array)$this->getMergeFieldsData();
		$mergeVars = MergeVars::fromArray($data);

		$list->setMergeFields($mergeVars );
		$this->assertTrue($list->hasMergeFields());
	}

}
