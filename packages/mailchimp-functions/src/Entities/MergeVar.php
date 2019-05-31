<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;
use \something\Mailchimp\Interfaces\ConvertsToUiField;

class MergeVar extends MailChimpEntity implements ConvertsToUiField
{

	/**
	 * @var string
	 */
	protected $mergeId;

	/**
	 * @var string
	 */
	protected $tag;
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var string
	 */
	protected $value;

	/**
	 * @var bool
	 */
	protected $required;

	protected $defaultValue;


	/**
	 * @return mixed
	 */
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	/**
	 * @param mixed $defaultValue
	 *
	 * @return MergeVar
	 */
	public function setDefaultValue($defaultValue)
	{
		$this->defaultValue = $defaultValue;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return MergeVar
	 */
	public function setName(string $name): MergeVar
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return MergeVar
	 */
	public function setType(string $type): MergeVar
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	/**
	 * @param array $options
	 *
	 * @return MergeVar
	 */
	public function setOptions(array $options): MergeVar
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 *
	 * @return MergeVar
	 */
	public function setValue(string $value): MergeVar
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMergeId(): string
	{
		return $this->mergeId;
	}

	/**
	 * @param string $mergeId
	 *
	 * @return MergeVar
	 */
	public function setMergeId(string $mergeId): MergeVar
	{
		$this->mergeId = $mergeId;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param mixed $tag
	 *
	 * @return MergeVar
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getRequired(): bool
	{
		return $this->required;
	}

	/**
	 * @param bool $required
	 *
	 * @return MergeVar
	 */
	public function setRequired(bool $required): MergeVar
	{
		$this->required = $required;
		return $this;
	}

	public static function fromArray(array $items): SimpleEntity
	{
		if (isset($items[ 'options' ])) {
			$items[ 'options' ] = (array)$items[ 'options' ];
		}
		$obj = parent::fromArray($items);
		if (isset($items[ 'merge_id' ])) {
			$obj->setMergeId($items[ 'merge_id' ]);
		}
		if( isset($items['mergeId'])){
            $obj->setMergeId($items[ 'mergeId' ]);

        }
		if (isset($items[ 'default_value' ])) {
			$obj->setDefaultValue($items[ 'default_value' ]);
		}
		return $obj;
	}

	/**
	 * Convert to UI field
	 *
	 * @return array
	 */
	public function toUiFieldConfig(): array
	{

		$html5type = null;
		switch ($this->getType()) {
			case 'dropdown':
				$type = 'select';
				break;
			case 'radio':
				$type = 'select';
				break;
			case 'checkboxes':
				$type = 'checkboxes';
				break;
			default:
				$type = 'input';
				$html5type = $this->getType();
				break;
		}
		return [
			'fieldId' => $this->getTag(),
			'fieldType' => $type,
			'html5Type' => $html5type,
			'isRequired' => $this->getRequired(),
			'label' => $this->getName(),
			'default' => $this->getDefaultValue()
		];

	}


}
