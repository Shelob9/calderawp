<?php


namespace something\Mailchimp\Entities;



use calderawp\interop\SimpleEntity;
use something\Mailchimp\Exception;

class Groups extends MailChimpEntity
{

	/**
	 * @var Group[]
	 */
	protected $groups;

	/**
	 * @var Categories[]
	 */
	protected $categories;

	public function __construct()
	{
		$this->groups =[];
		$this->categories = [];
	}

	/** @inheritdoc */
	public static function fromArray(array $items): SimpleEntity
	{
		$obj = new static();
		foreach ( $items as $group ){
			if( ! is_array( $group ) ) {
				if(  is_a($group, Group::class) ) {
					$obj->addGroup($group);
					continue;
				}else{
					$group = (array)$group;

				}
			}
			$obj->addGroup( Group::fromArray($group));

		}
		return$obj;
	}

	/**
	 * Add a group to collection
	 *
	 * @param Group $group
	 *
	 * @return $this
	 */
	public function addGroup(Group $group)
	{
		if (! is_array($this->groups)) {
			$this->groups = $this->getGroups();
		}
		$this->groups[$group->getId()] = $group;
		return $this;
	}

	/**
	 * Remove a group from collection
	 *
	 * @param string $id
	 *
	 * @return Group
	 * @throws Exception
	 */
	public function getGroup(string $id ) : Group
	{
		if( ! isset( $this->getGroups()[$id])){
			throw new Exception();
		}
		return $this->getGroups()[$id];

	}

	public function getGroups(): array
	{
		return is_array($this->groups) ? $this->groups : [];
	}

	/**
	 * @param string $categoryId
	 *
	 * @return mixed|Categories
	 * @throws Exception
	 */
	public function getCategoriesForGroup(string $categoryId){
		if( ! $this->hasCategoriesForGroup($categoryId) ){
			throw new Exception();

		}
		return $this->categories[$categoryId];
	}

	/**
	 * @param string $categoryId
	 *
	 * @return bool
	 */
	public function hasCategoriesForGroup(string $categoryId)  :bool
	{
		return isset($this->categories[$categoryId]);
	}

	/**
	 * @param string $categoryId
	 * @param Categories $categories
	 *
	 * @return Groups
	 */
	public function addCategoriesForGroup(string $categoryId, Categories$categories) : Groups
	{
		$this->categories[$categoryId]= $categories;
		return $this;

	}


}
