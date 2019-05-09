<?php

namespace something\Tests\Mailchimp\Entities;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\MergeVar;
use something\Mailchimp\Entities\MergeVars;

class MergeVarsTest extends TestCase
{


	/**
	 * @covers \something\Mailchimp\Entities\MergeVars::getMergeVar()
	 * @covers \something\Mailchimp\Entities\MergeVars::fromArray()
	 */
	public function testGetMergeVar()
	{
		$data = (array)$this->getMergeFieldsData();
		$id1 = $data[ 0 ]->merge_id;
		$id2 = $data[ 1 ]->merge_id;
		$id3 = 'fsf';
		$var3 = (new MergeVar())->setMergeId($id3);
		$data[] = $var3;
		$mergeVars = MergeVars::fromArray($data);
		$this->assertCount(4, $mergeVars->getMergeVars());

		$this->assertEquals($var3, $mergeVars->getMergeVar($id3));
	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVars::findMergeVarByTag()
	 */
	public function testGetMergeVarByTag()
	{
		$data = (array)$this->getMergeFieldsData();
		$id1 = $data[ 0 ]->merge_id;
		$id2 = $data[ 1 ]->merge_id;
		$id3 = 'fsf';
		$var3 = (new MergeVar())->setMergeId($id3)->setTag('food');
		$data[] = $var3;
		$mergeVars = MergeVars::fromArray($data);

		$this->assertEquals($var3, $mergeVars->findMergeVarByTag('food'));
	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVars::getMergeVars()
	 * @covers \something\Mailchimp\Entities\MergeVars::fromArray()
	 */
	public function testGetMergeVars()
	{
		$data = (array)$this->getMergeFieldsData();

		$mergeVars = MergeVars::fromArray($data);

		$this->assertCount(3, $mergeVars->getMergeVars());
	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVars::addMergeVar()
	 * @covers \something\Mailchimp\Entities\MergeVars::fromArray()
	 */
	public function testAddMergeVar()
	{

		$data = (array)$this->getMergeFieldsData();

		$id1 = $data[ 0 ]->merge_id;
		$id2 = $data[ 1 ]->merge_id;
		$id3 = 'fsf';
		$mergeVars = MergeVars::fromArray($data);

		$var3 = (new MergeVar())->setMergeId($id3);
		$mergeVars->addMergeVar($var3);
		$this->assertCount(4, $mergeVars->getMergeVars());

		$this->assertEquals($var3, $mergeVars->getMergeVar($id3));
		$this->assertEquals($id2, $mergeVars->getMergeVar($id2)->getMergeId());

	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVars::toUiFieldConfig()
	 */
	public function testToUiField()
	{
		$data = (array)$this->getMergeFieldsData();
		$mergeVar1 = MergeVar::fromArray((array)$data[0]);
		$fieldConfig1 = $mergeVar1->toUiFieldConfig();
		$mergeVar2 = MergeVar::fromArray((array)$data[1]);
		$fieldConfig2 = $mergeVar2->toUiFieldConfig();
		$mergeVars = new MergeVars();
		$mergeVars->addMergeVar($mergeVar1);
		$mergeVars->addMergeVar($mergeVar2);
		$this->assertEquals($fieldConfig1, $mergeVars->toUiFieldConfig()[0]);
		$this->assertEquals($fieldConfig2, $mergeVars->toUiFieldConfig()[1]);
	}


}
