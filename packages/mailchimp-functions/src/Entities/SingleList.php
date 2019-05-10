<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;
use calderawp\interop\Time;
use \something\Mailchimp\Interfaces\ConvertsToUiField;

class SingleList extends MailChimpEntity
	implements ConvertsToUiField
{

	/** @var int */
	protected $id;
	/**
	 * @var MergeVars
	 */
	protected $mergeFields;

	/**
	 * @var Groups
	 */
	protected $groupFields;

	/** @var string */
	protected $name;

	/**
	 * @var array
	 */
	protected $segments;

	/** @var array  */
	protected $mergeFieldIds;
	/** @var array  */
	protected $groupFieldIds;


	/** @var int */
	protected $accountId;
	/**
	 * @var \DateTimeInterface
	 */
	protected $updated;



	public function __construct()
	{
		$this->mergeFieldIds = [];
		$this->groupFieldIds = [];
	}

	/**
	 * @return array
	 */
	public function getMergeFieldIds(): array
	{
		return $this->mergeFieldIds;
	}

	/**
	 * @return array
	 */
	public function getGroupFieldIds(): array
	{
		return $this->groupFieldIds;
	}

	public static function fromDbResult(array $data ) : SingleList
	{
		$fields  = [
				'id' => ['key' =>'id', 'default' =>  0],
				'name' => ['key' =>'name', 'default' =>  ''],
				'account_id' => ['key' =>'accountId', 'default' =>  0],
				'list_id' => ['key' =>'listId','default' => 0 ],
				'group_fields' =>['key' => 'groupFields', 'default' =>  []],
				'merge_fields' => ['key' => 'mergeFields','default' =>[]],
				'segments' => ['key' => 'segments','default' =>[]],
				'updated' => ['key' => 'updated','default' =>''],

		];

		$prepared = [];
		foreach ($fields as $dbIndex => $field ){

			if( isset( $data[$dbIndex]) ){
				if(in_array( $field['key'], [
					'groupFields',
					'mergeFields',
					'segments'
				] ) ){
					$prepared[$field['key']] = unserialize($data[$dbIndex]);

				}else{
					$prepared[$field['key']] = $data[$dbIndex];

				}
			}else{
				$prepared[$field['key']] = $field['default'];
			}
		}
		return SingleList::fromArray($prepared);
	}

	/**
	 * Get array of data to use to write entity to database
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function toDbArray(): array {

		return [
		    'name' => $this->getName(),
			'account_id' => $this->getAccountId(),
			'list_id' =>  $this->getListId(),
			'group_fields' => $this->getGroupFieldsArray(),
			'merge_fields' => $this->getMergeFieldsArray(),
			'segments' => $this->getSegments(),
			'updated' => $this->getUpdated()->format(Time::FORMAT),
		];

	}

	public function hasMergeFields() : bool
	{
		return ! empty( $this->getMergeFieldsArray() );
	}
	protected function getMergeFieldsArray() : array
	{
		if( !  $this->mergeFields || empty($this->getMergeFields()->toArray()['mergeVars'])  ){
			return [];
		}
		return $this->getMergeFields()->toArray();
	}

	protected function getGroupFieldsArray() : array
	{
		if( ! $this->groupFields  ){
			return [];
		}
		return $this->getGroupFields()->toArray();

	}

	/**
	 *
	 * @param array $items
	 *
	 * @return SimpleEntity
	 */
	public static function fromArray(array $items): SimpleEntity
	{
		if (isset($items[ 'groupFields' ]) && is_array($items[ 'groupFields' ])) {
			$items[ 'groupFields' ] = Groups::fromArray($items[ 'groupFields' ]);
		}

		if (isset($items[ 'groups' ]) && is_array($items[ 'groups' ])) {
			$items[ 'groupFields' ] = Groups::fromArray($items[ 'groups' ]);
		}
		if (isset($items[ 'mergeFields' ]) && is_array($items[ 'mergeFields' ])) {
            if (isset($items[ 'mergeFields' ]['mergeVars'])&& is_array($items[ 'mergeFields' ]['mergeVars'])) {
                $items['mergeFields'] = MergeVars::fromArray($items['mergeFields'][ 'mergeVars' ]);
            }else{
                $items['mergeFields'] = MergeVars::fromArray($items['mergeFields']);
            }
        }

		if (isset($items[ 'id' ])) {
			if (is_numeric($items['id'])) {
				$items['id'] = (int) $items['id'];

			}else{
				$items[ 'list_id' ] = $items[ 'id' ];
				unset($items['id']);
			}
		}
		return parent::fromArray($items);
	}

	/**
	 * @return array
	 */
	public function toUiFieldConfig(): array
	{
		$fields = [
			$this->emailField(),
		];
		if (!empty($mergeVars = $this->getMergeFields()->getMergeVars())) {
			/** @var MergeVar $mergeVar */
			foreach ($mergeVars as $mergeVar) {
				$field = $mergeVar->toUiFieldConfig();
				$this->mergeFieldIds[] = $field[ 'fieldId' ];
				$fields[] = $field;
			}
		}
		if (!empty($this->groupFields)) {
			$groups = $this->getGroupFields()->getGroups();
			/** @var Group $group */
			foreach ($groups as $group) {
				$field = $group->toUiFieldConfig();

				if (
				    in_array( $group->getType(),[
                        'dropdown',
                        'checkboxes',
                        'radio'
                    ])
					&& $this->groupFields->hasCategoriesForGroup($group->getId())
				) {

					$categories = $this->groupFields->getCategoriesForGroup($group->getId())->getCategories();
					foreach ($categories as $category) {
						$field[ 'options' ][] = [
							'id' => $category[ 'id'],
							'value' => $category[ 'id' ],
							'label' => $category[ 'name' ],
						];
					}
					$field['value'] = ! empty( $field['default']) ? $field['default'] : [];


				} else {
					$field = $group->toUiFieldConfig();
					$field['value'] = ! empty( $field['default']) ? $field['default'] : '';
				}
				$this->groupFieldIds[] = $field['fieldId'];
				$fields[] = $field;
			}

		}
		
		return $fields;
	}

	/**
	 * @return array
	 */
	protected function emailField(): array
	{
		return [
			'fieldId' => $this->getEmailFieldId(),
			'fieldType' => 'input',
			'html5Type' => 'email',
			'isRequired' => true,
			'label' => 'Email',
			'default' => '',
		];
	}

	public function getEmailFieldId(): string
	{
		return 'mc-email';
	}

	/**
	 * @return MergeVars
	 */
	public function getMergeFields(): MergeVars
	{
		return $this->mergeFields;
	}

	/**
	 * @param MergeVars $mergeFields
	 *
	 * @return SingleList
	 */
	public function setMergeFields(MergeVars $mergeFields): SingleList
	{
		$this->mergeFields = $mergeFields;
		return $this;
	}

	/**
	 * @return Groups
	 */
	public function getGroupFields(): Groups
	{
		return $this->groupFields;
	}

	/**
	 * @param Groups $groupFields
	 *
	 * @return SingleList
	 */
	public function setGroupFields(Groups $groupFields): SingleList
	{
		$this->groupFields = $groupFields;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return is_string($this->name) ? $this->name : '';
	}

	/**
	 * @param string $name
	 *
	 * @return SingleList
	 */
	public function setName(string $name): SingleList
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getSegments(): array
	{
		return is_array($this->segments) ? $this->segments : [];
	}

	/**
	 * @param array $segments
	 *
	 * @return SingleList
	 */
	public function setSegments(array $segments): SingleList
	{
		$this->segments = $segments;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAccountId(): int
	{
		return $this->accountId;
	}

	/**
	 * @param int $accountId
	 *
	 * @return SingleList
	 */
	public function setAccountId(int $accountId = null): SingleList
	{
		$this->accountId = $accountId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return SingleList
	 */
	public function setId(int $id): SingleList
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return \DateTimeInterface
	 * @throws \Exception
	 */
	public function getUpdated(): \DateTimeInterface
	{
		if( !$this->updated ){
			return new \DateTimeImmutable('now');
		}
		return $this->updated;
	}

	/**
	 * @param string|integer|\DateTimeInterface $updated
	 *
	 * @return SingleList
	 * @throws \Exception
	 */
	public function setUpdated( $updated): SingleList
	{
		if (is_numeric($updated) ){
			$updated = (new \DateTimeImmutable())->setTimestamp($updated);

		}elseif( is_string($updated)){
			$updated = Time::dateTimeFromMysql($updated);
		}
		$this->updated = $updated;
		return $this;
	}





}
