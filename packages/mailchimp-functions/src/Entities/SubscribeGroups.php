<?php


namespace something\Mailchimp\Entities;


use something\Mailchimp\Exception;

class SubscribeGroups {

	/**
	 * @var Groups
	 */
	protected $groups;

	/**
	 * @var array
	 */
	protected $data;


	/**
	 * Reduce object to the form needed for API request
	 *
	 * @return array
	 */
	public function toArray(){
		if( ! is_array( $this->data ) ){
			$this->resetData();
		}

		return $this->data;
	}

	/**
	 * Set interest groups that are allowed
	 *
	 * @param Groups $groups
	 *
	 * @return $this
	 */
	public function setGroups( Groups $groups )
	{
		$this->groups = $groups;
		$this->resetData();
		return $this;
	}

	/**
	 * Set the value for one interest group - join or not
	 *
	 * @param string $groupId ID of group to join/ leave
	 * @param bool $join Set true to join or false to leave
	 *
	 * @return SubscribeGroups
	 */
	public function setGroupJoin( string $groupId, bool $join ) : SubscribeGroups
	{
		if( is_array( $this->data ) && array_key_exists($groupId, $this->data) ) {
			$this->data[$groupId] = $join;
		}
		return $this;
	}

	/**
	 * Set the values for all interest groups - join or not
	 *
	 * @param array $options
	 *
	 * @return SubscribeGroups
	 * @throws \something\Mailchimp\Exception
	 */
	public function setGroupsJoins( array $options ): SubscribeGroups
	{
		foreach ( $options as $groupId => $join){
			if( $this->groups->getGroup($groupId)){
				if (is_array($join)) {
					foreach ($join as $interest ){
						$this->setGroupJoin($interest, true);
					}
				} else {
					$this->setGroupJoin($groupId, (bool)$join);
				}
			}
		}

		return $this;
	}


	/**
	 * Reset join group data
	 */
	protected function resetData()
	{
		$this->data = [];
		if( isset( $this->groups ) ){
			/** @var Group $group */
			foreach ($this->groups->getGroups() as $group ){
				if ('checkboxes' === $group->getType() ) {
					try {
						$categories = $this->groups->getCategoriesForGroup($group->getId());
					} catch (Exception $e) {
						$categories = false;
					}
					if( $categories ){
						foreach ( $categories->toArray() as $interests ){
							foreach ($interests as $interest ){
								$this->data[$interest['id']] = false;

							}
						}
					}
				} else {
					$this->data[ $group->getGroupId() ] = false;

				}
			}
		}

	}


}
