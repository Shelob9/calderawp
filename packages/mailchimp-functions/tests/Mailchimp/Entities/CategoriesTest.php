<?php

namespace something\Tests\Mailchimp\Entities;

use something\Mailchimp\Entities\Categories;
use something\Tests\Mailchimp\TestCase;

class CategoriesTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\Categories::fromArray()
	 */
	public function testFromArray()
	{
		$data = $this->getCategoriesData();
		$cats = Categories::fromArray($data['interests']);
		$this->assertCount(3,$cats->toArray());
		$arrayCats = $cats->toArray();
		$i = 0;

		$this->assertEquals('45907f0c59',$cats->getListId());
		foreach ($data['interests'] as $interest ){
			$this->assertArrayHasKey($interest->id,$arrayCats['categories']);
			$i++;
		}
		$this->assertEquals($i,count($cats->toArray()));

	}
	/**
	 * @covers \something\Mailchimp\Entities\Categories::toUiFieldConfig()
	 * @covers \something\Mailchimp\Entities\Categories::fromArray()
	 */
	public function testToUiFieldConfig()
	{
		$data = $this->getCategoriesData();
		$cats = Categories::fromArray($data['interests']);
		$fields = $cats->toUiFieldConfig();
		$this->assertCount(3,$fields);
		$i = 0;
		foreach ($data['interests'] as $interest ){
			$found = false;
			foreach ($fields as $field ){
				if( $interest->id === $field['fieldId']){
					$found = true;
					break;
				}
			}
			$this->assertTrue($found);
			$i++;
		}
		$this->assertEquals(3,$i);


	}
}
