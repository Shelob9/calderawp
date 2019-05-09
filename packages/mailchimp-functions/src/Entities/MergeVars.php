<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;
use something\Mailchimp\Exception;
use something\Mailchimp\Interfaces\ConvertsToUiField;

class MergeVars extends MailChimpEntity implements ConvertsToUiField
{

	/**
	 * @var array
	 */
	protected $mergeVars;

	public static function fromArray(array $items): SimpleEntity
	{

		$obj = new static();
		foreach ( $items as $property => $mergeVar ){
			if( 'list_id' === $property ){
				$obj->setListId($mergeVar);
				continue;
			}
			if( ! is_array( $mergeVar ) ) {
				if(  is_a($mergeVar, MergeVar::class) ) {

                    $obj->addMergeVar($mergeVar);
					continue;
				}else{
					$mergeVar = (array)$mergeVar;
				}
			}
			$obj->addMergeVar( MergeVar::fromArray($mergeVar));

		}

		return $obj;
	}

	/**
	 * @param MergeVar $mergeVar
	 *
	 * @return MergeVars
	 */
	public function addMergeVar(MergeVar $mergeVar ) : MergeVars
	{
		if( ! is_array( $this->mergeVars )){
			$this->mergeVars = $this->getMergeVars();
		}
		$this->mergeVars[$mergeVar->getMergeId()] = $mergeVar;
		return $this;
	}

	/**
	 * @param string $id
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function getMergeVar(string  $id ){
		if( ! isset( $this->getMergeVars()[$id])){
			throw new Exception();
		}
		return $this->getMergeVars()[$id];
	}

	/**
	 * Find a merge var by its tag
	 *
	 * @param string $tag
	 *
	 * @return null|MergeVar
	 */
	public function findMergeVarByTag( string  $tag ) :?MergeVar
	{
		/** @var MergeVar $mergeVar */
		foreach ( $this->mergeVars as $mergeVar ){
			if( $tag === $mergeVar->getTag() ){
				return $mergeVar;
			}
		}
		return null;
	}
	/**
	 * @return array
	 */
	public function getMergeVars(): array
	{
		return is_array($this->mergeVars) ? $this->mergeVars : [];
	}

	public function toUiFieldConfig() : array
	{
		$fieldConfigs = [];
		/** @var MergeVar $mergeVar */
		foreach ( $this->getMergeVars() as $mergeVar ){
			$fieldConfigs[] = $mergeVar->toUiFieldConfig();
		}
		return $fieldConfigs;
	}

}
