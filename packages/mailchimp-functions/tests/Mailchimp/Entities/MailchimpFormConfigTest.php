<?php

namespace something\Tests\Mailchimp\Entities;

use something\Mailchimp\Entities\MailchimpFormConfig;
use something\Tests\Mailchimp\TestCase;

class MailchimpFormConfigTest extends TestCase
{

    public function testGetProcessor()
    {

        $form = new MailchimpFormConfig();
        $form->setProcessor($this->getProcessor());
        $this->assertEquals($this->getProcessor(), $form->getProcessor());
    }

    public function testGetId()
    {
        $form = new MailchimpFormConfig();
        $this->assertEquals('', $form->getId());
        $form->setId('Roy');
        $this->assertEquals('Roy', $form->getId());
    }

    public function testGetFields()
    {
        $form = new MailchimpFormConfig();
        $this->assertEquals([], $form->getFields());
        $fields = [];
        $form->setFields($fields);
        $this->assertEquals($fields, $form->getFields());
    }

    public function testGetName()
    {
        $form = new MailchimpFormConfig();
        $this->assertEquals('', $form->getName());
        $form->setName('Roy');
        $this->assertEquals('Roy', $form->getName());


    }

    public function testGetProcessors()
    {
        $form = new MailchimpFormConfig();
        $form->setProcessor($this->getProcessor());
        $this->assertEquals([$this->getProcessor()], $form->getProcessors());
    }

    public function testFromArray()
    {
        $data = [
            'name' => 'roy',
            'processor' => $this->getProcessor(),
            'id' => 'sivan',
            'fields' =>[
                [
                    'fieldType' => 'email'
                ]
            ]
        ];
        $form = MailchimpFormConfig::fromArray($data);
        $this->assertEquals($data['name'], $form->getName() );
        $this->assertEquals($data['fields'], $form->getFields() );
        $this->assertEquals($data['id'], $form->getId() );
        $this->assertEquals($data['processor'], $form->getProcessor() );
     }

    public function testToArray()
    {
        $data = [
            'name' => 'roy',
            'processor' => $this->getProcessor(),
            'id' => 'sivan',
            'fields' =>[
                [
                    'fieldType' => 'email'
                ]
            ]
        ];
        $form = MailchimpFormConfig::fromArray($data);

        $this->assertEquals($data['name'], $form->toArray()['name'] );
        $this->assertEquals($data['id'], $form->toArray()['id'] );
        $this->assertEquals(3, count($form->toArray()['fields']) );
        $this->assertEquals([$data['processor']], $form->toArray()['processors'] );
     }

    protected function getProcessor()
    {
        return [
            "type" => "mc-subscribe",
            "listId" => 'f43211',
            'emailField' => 'emailFieldId',
            'mergeFields' =>['FNAME'],
            'groupFields' => ['g1'],
            'submitUrl' => 'https://goot.toor'
        ];
    }
}
