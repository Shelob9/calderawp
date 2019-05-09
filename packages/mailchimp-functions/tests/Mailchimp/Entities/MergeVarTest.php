<?php

namespace something\Tests\Mailchimp;

namespace something\Tests\Mailchimp\Entities;
use something\Mailchimp\Entities\MergeVar;
use something\Tests\Mailchimp\TestCase;
class MergeVarTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setOptions()
	 * @covers \something\Mailchimp\Entities\MergeVar::getOptions()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetOptions()
	{

		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals((array)$data[ 'options' ], $mergeVar->getOptions());
		$array = $mergeVar->toArray();
		$this->assertEquals((array)$data[ 'options' ], $array[ 'options' ]);

	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setRequired()
	 * @covers \something\Mailchimp\Entities\MergeVar::getRequired()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetRequired()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'required' ], $mergeVar->getRequired());
		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'required' ], $array[ 'required' ]);
	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setDefaultValue()
	 * @covers \something\Mailchimp\Entities\MergeVar::getDefaultValue()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetDefaultValue()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'default_value' ], $mergeVar->getDefaultValue());
		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'default_value' ], $array[ 'defaultValue' ]);

	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setType()
	 * @covers \something\Mailchimp\Entities\MergeVar::getType()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetType()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'type' ], $mergeVar->getType());

		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'type' ], $array[ 'type' ]);
	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setValue()
	 * @covers \something\Mailchimp\Entities\MergeVar::getValue()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetValue()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$data[ 'value' ] = 'roy';
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'value' ], $mergeVar->getValue());

		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'value' ], $array[ 'value' ]);
	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setMergeId()
	 * @covers \something\Mailchimp\Entities\MergeVar::getMergeId()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetMergeId()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'merge_id' ], $mergeVar->getMergeId());

		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'merge_id' ], $array[ 'mergeId' ]);
	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setTag()
	 * @covers \something\Mailchimp\Entities\MergeVar::getTag()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetTag()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'tag' ], $mergeVar->getTag());

		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'tag' ], $array[ 'tag' ]);
	}
	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::setName()
	 * @covers \something\Mailchimp\Entities\MergeVar::getName()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 * @covers \something\Mailchimp\Entities\MergeVar::toArray()
	 */
	public function testSetName()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$this->assertEquals($data[ 'name' ], $mergeVar->getName());

		$array = $mergeVar->toArray();
		$this->assertEquals($data[ 'name' ], $array[ 'name' ]);
	}

	/**
	 * @covers \something\Mailchimp\Entities\MergeVar::toUiFieldConfig()
	 * @covers \something\Mailchimp\Entities\MergeVar::fromArray()
	 */
	public function testToUiField()
	{
		$data = (array)$this->getMergeFieldsData()[ 0 ];
		$mergeVar = MergeVar::fromArray($data);
		$fieldConfig = $mergeVar->toUiFieldConfig();
		$this->assertEquals('FNAME', $fieldConfig['fieldId']);
		$this->assertEquals('input', $fieldConfig['fieldType']);
		$this->assertEquals('text', $fieldConfig['html5Type']);
		$this->assertEquals(false, $fieldConfig['isRequired']);
		$this->assertEquals('First Name', $fieldConfig['label']);
		$this->assertEquals('', $fieldConfig['default']);
	}
}
