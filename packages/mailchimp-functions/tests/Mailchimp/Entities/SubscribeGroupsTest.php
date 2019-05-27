<?php

namespace something\Tests\Mailchimp\Entities;
use something\Mailchimp\Entities\Group;
use something\Tests\Mailchimp\TestCase;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\SubscribeGroups;

class SubscribeGroupsTest extends TestCase
{

	/**
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroups()
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::toArray()
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroupJoin()
	 */
	public function testSetGroupJoin()
	{
        $this->markTestSkipped('Does not reflect how it actually works');
        $data = (array)$this->getGroupsData();

		$id1 = $data[ 0 ]->id;
		$id2 = $data[ 1 ]->id;


		$groups = Groups::fromArray($data);
		$subscribeGroups = new SubscribeGroups();
		$subscribeGroups->setGroups($groups);
		$subscribeGroups->setGroupJoin($id2, true);
		$subscribeGroups->setGroupJoin($id1, false);
		$array = $subscribeGroups->toArray();
		$this->assertTrue($array[ $id2 ]);

	}

	/**
	 * @covers \something\Mailchimp\Entities\SubscribeGroups::setGroupJoins()
	 */
	public function testSetGroupJoins()
	{
	    $this->markTestSkipped('Does not reflect how it actually works');
		$data = (array)$this->getGroupsData();

		$id1 = $data[ 0 ]->id;
		$id2 = $data[ 1 ]->id;

		$groups = new class extends Groups {
            /**
             * @inheritDoc
             */
            public function hasCategoriesForGroup(string $categoryId): bool
            {
                return true;
            }

            /**
             * @inheritDoc
             */
            public function getCategoriesForGroup(string $categoryId)
            {
                return [
                    'f1',
                    'f2'
                ];
            }


        };

		$joins = [
			$id1 => null,
			$id2 => [
			    'f1' => 1,
                'f2' => 12
            ],
		];

		$subscribeGroups = new SubscribeGroups();
		$subscribeGroups->setGroups($groups);
		$subscribeGroups->setGroupsJoins($joins);
		$array = $subscribeGroups->toArray();
		$this->assertTrue($array[ $id2 ]);
	}

}
