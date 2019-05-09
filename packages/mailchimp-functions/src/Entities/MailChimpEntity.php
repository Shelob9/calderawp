<?php


namespace something\Mailchimp\Entities;

use \calderawp\interop\Contracts\Arrayable;
use calderawp\interop\SimpleEntity;

abstract class MailChimpEntity extends \calderawp\interop\SimpleEntity
{
	/**
	 * @var string
	 */
	protected $listId;

	/**
	 * @return string
	 */
	public function getListId(): string
	{
		return $this->listId;
	}

	/**
	 * @param string $listId
	 *
	 * @return MailChimpEntity
	 */
	public function setListId(string $listId): MailChimpEntity
	{
		$this->listId = $listId;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public static function fromArray( array $items ) : SimpleEntity
	{
		$obj = new static();
		foreach ( $items as $property => $value ){
			if (null !== $value) {
				$obj = $obj->__set($property, $value);
			}
		}
		if (isset($items[ 'list_id' ])) {
			$obj->setListId($items[ 'list_id' ]);
		}
		return $obj;
	}

	public function toArray(): array
	{
		return parent::toArray();
	}


}
