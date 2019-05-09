<?php

namespace something\Tests\Mailchimp\Entities;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\SubscribeMergeVars;

class SubscribeMergeVarsTest extends TestCase
{

	public function testSetMergeValue()
	{
		$data = (array)$this->getMergeFieldsData();

		$mergeVars = MergeVars::fromArray($data);
		$tag1 = $data[ 0 ]->tag;
		$tag2 = $data[ 1 ]->tag;


		$subscribeMergeVars = new SubscribeMergeVars();
		$subscribeMergeVars->setMergeVars($mergeVars);
		$subscribeMergeVars->setMergeValue( $tag1, 'Roy');
		$subscribeMergeVars->setMergeValue( $tag2, 'Troy');
		$array = $subscribeMergeVars->toArray();
		$this->assertEquals('Roy',$array[$tag1]);
		$this->assertEquals('Troy',$array[$tag2]);


	}

	public function testSetMergeValues()
	{
		$data = (array)$this->getMergeFieldsData();

		$mergeVars = MergeVars::fromArray($data);
		$tag1 = $data[ 0 ]->tag;
		$tag2 = $data[ 1 ]->tag;


		$subscribeMergeVars = new SubscribeMergeVars();
		$subscribeMergeVars->setMergeVars($mergeVars);
		$subscribeMergeVars->setMergeValues([
			$tag1 => 'Roy',
			$tag2 => 'Troy'
		]);
		$array = $subscribeMergeVars->toArray();
		$this->assertEquals('Roy',$array[$tag1]);
		$this->assertEquals('Troy',$array[$tag2]);
	}
}
