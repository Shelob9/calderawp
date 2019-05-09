<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;
use \something\Mailchimp\Interfaces\ConvertsToUiField;

class Categories extends MailChimpEntity
{

	/** @var array  */
	protected $categories;

	/** @var string */
	protected $id;
	public function __construct()
	{
		$this->categories = [];
	}

	/**
	 * @param array $items
	 *
	 * @return SimpleEntity
	 */
	public static function fromArray(array $items): SimpleEntity
	{

		$obj = new static();
		foreach ($items as $category){
			if( ! is_array($category)){
				$category = (array)$category;
			}
			$obj->setListId($category['list_id']);
			$obj->categories[$category['id']]= [
				'name' => $category[ 'name'],
				'id' => $category[ 'id' ]
			];
		}
		return $obj;
	}

	/**
	 * @return array
	 */
	public function toUiFieldConfig(): array
	{
		$fields = [];
		if( ! empty( $this->categories ) ){
			foreach ($this->categories as $category ){
				$fields[] = [
					'fieldId' => $category['id'],
					'label' => $category['name'],
				];
			}
		}

		return $fields;
	}

	/**
	 * @return array
	 */
	public function getCategories(): array
	{
		return $this->categories;
	}

}
