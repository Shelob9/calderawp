<?php


namespace something\Mailchimp\Entities;


use calderawp\interop\SimpleEntity;

class MailchimpFormConfig extends SimpleEntity
{

    /** @var string */
    protected $id;
    /** @var string */
    protected $name;
    /** @var array */
    protected $fields;
    /** @var array */
    protected $processor;


    public function getProcessors()
    {
        return [$this->processor];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return is_string($this->id) ? $this->id : '';
    }

    /**
     * @param string $id
     */
    public function setId(string $id): MailchimpFormConfig
    {
        $this->id = $id;
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
     */
    public function setName(string $name): MailchimpFormConfig
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return is_array($this->fields) ? $this->fields : [];
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): MailchimpFormConfig
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return array
     */
    public function getProcessor(): array
    {
        return $this->processor;
    }

    /**
     * @param array $processor
     */
    public function setProcessor(array $processor): MailchimpFormConfig
    {
        $this->processor = $processor;
        return $this;
    }


    protected function getSubmitButtonId(): string
    {
        return 'mc-submit';
    }

    protected function getEmailFieldId(): string
    {
        return 'mc-email';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $procesor = $array['processor'];
        $array['processors'] = [$procesor];
        unset($array['processor']);
        $array['fields'][] = [
            'fieldType' => 'submit',
            'fieldId' => $this->getSubmitButtonId(),
            'label' => 'Subscribe'
        ];
        $array['fields'][] = [
            'fieldType' => 'email',
            'fieldId' => $this->getEmailFieldId(),
            'label' => 'Email'
        ];
        $array['rows'] = [
            [
                'rowId' => 'r1',
                'columns' => [
                    [
                        'columnId' => 'r1-c1',
                        'width' => '1/2',
                        'fields' => [$this->getEmailFieldId()]
                    ],
                    [
                        'columnId' => 'r1-c2',
                        'width' => '1/2',
                        'fields' => [$this->getProcessor()['mergeFields'][0]]
                    ]
                ]
            ],
            [
                'rowId' => 'r2',
                'columns' => [
                    [
                        'columnId' => 'r2-c1',
                        'width' => '1/2',
                        'fields' => [$this->getProcessor()['mergeFields'][1]]
                    ],
                    [
                        'columnId' => 'r2-c2',
                        'width' => '1/2',
                        'fields' => [$this->getProcessor()['mergeFields'][2]]
                    ]

                ]
            ]
        ];
        $groupFields = $this->getProcessor()['groupFields'];
        if (!empty($groupFields)) {
            foreach ($groupFields as $fieldId) {

                $array['rows'][] = [
                    'rowId' => "r-$fieldId",
                    'columns' => [
                        [
                            'columnId' => $fieldId,
                            'width' => '1/1',
                            'fields' => [$fieldId]
                        ],
                    ]
                ];
            }
        }
        $array['rows'][] = [
            'rowId' => "r-0",
            'columns' => [
                [
                    'columnId' => 'r0-c1',
                    'width' => '1/1',
                    'fields' => [$this->getSubmitButtonId()]
                ],
            ]
        ];

        return $array;
    }


}