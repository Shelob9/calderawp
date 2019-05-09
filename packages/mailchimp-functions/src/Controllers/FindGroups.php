<?php


namespace something\Mailchimp\Controllers;


use Mailchimp\MailchimpLists;
use something\Mailchimp\Entities\Categories;
use something\Mailchimp\Entities\Group;
use something\Mailchimp\Entities\Groups;

class FindGroups extends MailchimpProxy
{

	/**
	 * @var Categories
	 */
	protected $categories;


	public function __construct(MailchimpLists $mailchimp)
	{
		$this->categories = [];
		parent::__construct($mailchimp);
	}

	public function __invoke(string $listId)
	{

        $groups = $this->getGroupFieldsFromApi($listId);
		return [
			'listId' => $listId,
			'groups' => $groups,
		];
	}

	public function getCategories(string $listId, string $categoryId): Categories
	{
		if( ! isset($this->categories[$categoryId]) ){
			$body = $this->getMailchimp()->getInterests( $listId,$categoryId );
			$this->categories[$categoryId] = Categories::fromArray($body->interests);

		}
		return $this->categories[$categoryId];
	}

    /**
     * @param string $listId
     * @return array|Groups
     */
    public function getGroupFieldsFromApi(string $listId)
    {
        $body = $this->getMailchimp()->getInterestCategories($listId);
        $groups = isset($body->categories) ? (array)$body->categories : [];
        /** @var Groups $groups */
        $groups = Groups::fromArray($groups)->setListId($listId);
        if (!empty($groups->getGroups())) {
            /** @var Group $group */
            foreach ($groups->getGroups() as $group) {
                if ('checkboxes' == $group->getType()) {
                    try {
                        $cats = $this->getCategories($listId, $group->getId());
                        $groups->addCategoriesForGroup($group->getId(), $cats);
                    } catch (\Exception $e) {
                    }
                }

            }
        }
        return $groups;
    }
}
