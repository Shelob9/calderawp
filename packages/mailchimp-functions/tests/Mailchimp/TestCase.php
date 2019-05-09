<?php


namespace something\Tests\Mailchimp;


abstract class TestCase extends \PHPUnit\Framework\TestCase
{

	protected function getGroupsData(): array
	{
		return json_decode(file_get_contents(__DIR__ . '/data/groups.json'));
	}
	protected function getMergeFieldsData(): array
	{
		return json_decode(file_get_contents(__DIR__ . '/data/mergeFields.json'));
	}

	protected function getListsData() : array
	{
		return (array) json_decode(file_get_contents(__DIR__ . '/data/lists.json'));
	}

	protected function getListData() : array
	{
		return (array ) json_decode(file_get_contents(__DIR__ . '/data/list.json'));
	}

	protected function getCategoriesData() : array
	{
		return (array ) json_decode(file_get_contents(__DIR__ . '/data/categories.json'));

	}

}
