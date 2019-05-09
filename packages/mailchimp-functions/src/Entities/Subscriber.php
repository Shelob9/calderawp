<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;

class Subscriber extends MailChimpEntity
{

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var Groups
	 */
	protected $groups;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var SubscribeGroups
	 */
	protected $subscribeGroups;


	/**
	 * @var SubscribeMergeVars
	 */
	protected $subscribeMergeVars;

	/**
	 * @var MergeVars
	 */
	protected $mergeVars;

	public static function fromArray(array $items): SimpleEntity
	{
		$obj = new static();
		if (isset($items[ 'groups' ])) {
			if (!is_a($items[ 'groups' ], Groups::class)) {
				if (!is_array($items[ 'groups' ])) {
					$items[ 'groups' ] = (array)$items[ 'groups' ];
				}
				$items[ 'groups' ] = Groups::fromArray($items[ 'groups' ]);
			}
			$obj->setGroups($items[ 'groups' ]);

			if (isset($items[ 'subscribeGroups' ])) {
				if (is_a($items[ 'subscribeGroups' ], SubscribeGroups::class)) {

					$subscribeGroups = new SubscribeGroups();
					$subscribeGroups->setGroups($obj->getGroups());
					$subscribeGroups->setGroupsJoins($items[ 'subscribeGroups' ]);
				} else {
					if (!is_array($items[ 'subscribeGroups' ])) {
						$items[ 'subscribeGroups' ] = (array)$items[ 'subscribeGroups' ];
					}
					$subscribeGroups = new SubscribeGroups();
					$subscribeGroups->setGroups($obj->getGroups());
					$subscribeGroups->setGroupsJoins($items[ 'subscribeGroups' ]);
				}

				$obj->setSubscribeGroups($subscribeGroups);
			}
		}
		if (isset($items[ 'mergeVars' ])) {
			if (!is_a($items[ 'mergeVars' ], MergeVars::class)) {
				if (!is_array($items[ 'mergeVars' ])) {
					$items[ 'mergeVars' ] = (array)$items[ 'mergeVars' ];
				}
				$items[ 'mergeVars' ] = MergeVars::fromArray($items[ 'mergeVars' ]);
			}
			$obj->setMergeVars($items[ 'mergeVars' ]);
		}

		if (isset($items[ 'subscribeMergeVars' ])) {
			if (!is_a($items[ 'subscribeMergeVars' ], SubscribeMergeVars::class)) {
				if (!is_array($items[ 'subscribeMergeVars' ])) {
					$items[ 'subscribeMergeVars' ] = (array)$items[ 'subscribeMergeVars' ];
				}
				$items[ 'subscribeMergeVars' ] = (
				new SubscribeMergeVars())
					->setMergeVars($obj->getMergeVars())
					->setMergeValues($items[ 'subscribeMergeVars' ]
					);

			}
			$obj->setSubscribeMergeVars($items[ 'subscribeMergeVars' ]);
		}
		if (isset($items[ 'email' ])) {
			$obj->setEmail($items[ 'email' ]);
		}
		if (isset($items[ 'status' ])) {
			$obj->status = $items[ 'status' ];
		}

		return $obj;

	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 *
	 * @return Subscriber
	 */
	public function setEmail(string $email): Subscriber
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return Groups
	 */
	public function getGroups(): Groups
	{
		return $this->groups;
	}

	/**
	 * @param Groups $groups
	 *
	 * @return Subscriber
	 */
	public function setGroups(Groups $groups): Subscriber
	{
		$this->groups = $groups;
		return $this;
	}

	/**
	 * @return MergeVars
	 */
	public function getMergeVars(): MergeVars
	{
		return $this->mergeVars;
	}

	/**
	 * @param MergeVars $mergeVars
	 *
	 * @return Subscriber
	 */
	public function setMergeVars(MergeVars $mergeVars): Subscriber
	{
		$this->mergeVars = $mergeVars;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return !empty($this->status) && is_string($this->status) ? $this->status : 'subscribed';
	}

	/**
	 * @param string $status
	 *
	 * @return Subscriber
	 */
	public function setStatus(string $status): Subscriber
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * @return SubscribeGroups
	 */
	public function getSubscribeGroups(): SubscribeGroups
	{
		return $this->subscribeGroups;
	}

	/**
	 * @param SubscribeGroups $subscribeGroups
	 *
	 * @return Subscriber
	 */
	public function setSubscribeGroups(SubscribeGroups $subscribeGroups): Subscriber
	{
		$this->subscribeGroups = $subscribeGroups;
		return $this;
	}

	/** @inheritdoc */
	public function toArray(): array
	{
		$array = parent::toArray();
		if (!isset($array[ 'status' ])) {
			$array[ 'status' ] = $this->getStatus();
		}
		return $array;
	}

	/**
	 * @return SubscribeMergeVars
	 */
	public function getSubscribeMergeVars(): SubscribeMergeVars
	{
		return $this->subscribeMergeVars;
	}

	/**
	 * @param SubscribeMergeVars $subscribeMergeVars
	 *
	 * @return Subscriber
	 */
	public function setSubscribeMergeVars(SubscribeMergeVars $subscribeMergeVars): Subscriber
	{
		$this->subscribeMergeVars = $subscribeMergeVars;
		return $this;
	}


}
