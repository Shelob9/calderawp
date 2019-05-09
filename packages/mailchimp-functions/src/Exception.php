<?php


namespace something\Mailchimp;


class Exception extends \calderawp\interop\Exception
{


}

interface PostContract {
	/**
	 * Get post ID
	 *
	 * @return int
	 */
	public function getID() : string;

	/**
	 *
	 * @param int $ID
	 *
	 * @return Post
	 */
	public function setID(int $ID): PostContract;
}

class Post implements PostContract{

	/**
	 * Post ID
	 *
	 * @var int
	 */
	protected $ID;

	/**
	 * Get post ID
	 *
	 * @return int
	 */
	public function getID() : string
	{
		return $this->ID;
	}

	/**
	 *
	 * @param int $ID
	 *
	 * @return Post
	 */
	public function setID(int $ID): PostContract
	{
		$this->ID = $ID;
		return $this;
	}

}


function addFloatToInteger(float $a,int$b) : float
{
	return $a * $b;
}
