<?php

namespace something\Tests\Mailchimp\Entities;
use something\Mailchimp\Entities\SubscribeGroups;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\Subscriber;

class SubscriberTest extends TestCase
{

	/**
	 * @covers Subscriber::setEmail()
	 * @covers Subscriber::getEmail()
	 * @covers Subscriber::fromArray()
	 * @covers Subscriber::toArray()
	 */
	public function testSetEmail()
	{
		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$email = 'roy@hiroy.club';
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email
		]);

		$this->assertEquals($email, $subscriber->getEmail());
		$array = $subscriber->toArray();
		$this->assertEquals($email, $array['email']);

	}

	/**
	 * @covers Subscriber::setMergeVars()
	 * @covers Subscriber::getMergeVars()
	 * @covers Subscriber::fromArray()
	 * @covers Subscriber::toArray()
	 */
	public function testSetMergeVars()
	{

		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$email = 'roy@hiroy.club';
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email
		]);

		$this->assertEquals(MergeVars::fromArray($mergeVars), $subscriber->getMergeVars());

	}
	/**
	 * @covers Subscriber::setGroups()
	 * @covers Subscriber::getGroups()
	 * @covers Subscriber::fromArray()
	 * @covers Subscriber::toArray()
	 */
	public function testSetGroups()
	{
		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$email = 'roy@hiroy.club';
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email
		]);
		$this->assertEquals(Groups::fromArray($groups), $subscriber->getGroups() );

	}
	/**
	 * @covers Subscriber::setMergeVars()
	 * @covers Subscriber::getMergeVars()
	 * @covers Subscriber::fromArray()
	 * @covers Subscriber::toArray()
	 */
	public function testSetStatus()
	{
		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$email = 'roy@hiroy.club';
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email
		]);

		$this->assertEquals('subscribed', $subscriber->getStatus());
		$array = $subscriber->toArray();
		$this->assertEquals('subscribed', $array['status']);

	}
	/**
	 * @covers Subscriber::setStatus()
	 * @covers Subscriber::getStatus()
	 * @covers Subscriber::fromArray()
	 * @covers Subscriber::toArray()
	 */
	public function testGetStatus()
	{

		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$email = 'roy@hiroy.club';
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email,
			'status' => 'pending'
		]);

		$this->assertEquals('pending', $subscriber->getStatus());
		$array = $subscriber->toArray();
		$this->assertEquals('pending', $array['status']);
	}

	/**
	 * @covers \something\Mailchimp\Entities\Subscriber::getSubscribeGroups()
	 */
	public function testGetSubscribeGroups()
	{

		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$id1 = $groups[ 0 ]->id;
		$id2 = $groups[ 1 ]->id;
		$email = 'roy@hiroy.club';
		/** @var Subscriber $subscriber */
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email,
			'status' => 'pending',
			'subscribeGroups' => [
				$id1 => false,
				$id2 => true,
			]
		]);
		$this->assertTrue( $subscriber->getSubscribeGroups()->toArray()[$id2] );
	}


	/**
	 * @covers \something\Mailchimp\Entities\Subscriber::getSubscribeMergeVars()
	 */
	public function testGetSubscribeMergeVars()
	{

		$mergeVars = (array) $this->getMergeFieldsData();
		$groups = (array)$this->getGroupsData();
		$tag1 = $mergeVars[ 0 ]->tag;
		$tag2 = $mergeVars[ 1 ]->tag;
		$email = 'roy@hiroy.club';
		/** @var Subscriber $subscriber */
		$subscriber = Subscriber::fromArray([
			'groups' => $groups,
			'mergeVars' => $mergeVars,
			'email' => $email,
			'status' => 'pending',
			'subscribeMergeVars' => [
				'FNAME' => 'Roy',
				'LNAME' => 'Corkum',
			]
		]);
		$array = $subscriber->getSubscribeMergeVars()->toArray();
		$this->assertEquals('Roy', $array['FNAME']);
		$this->assertEquals('Corkum', $array['LNAME']);
	}
}
