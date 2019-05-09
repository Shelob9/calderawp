<?php


namespace something\Mailchimp\Controllers;


use something\Mailchimp\Entities\Subscriber;

trait HandlesSubscriptionParams
{
	/**
	 * @param Subscriber $subscriber
	 * @param string $status
	 *
	 * @return array
	 */
	protected function prepareParams(Subscriber $subscriber, string $status): array
	{
		$interests = $subscriber->getSubscribeGroups()->toArray();
		$params = [
			"status" => $status,
			'merge_fields' => $subscriber->getSubscribeMergeVars()->toArray(),
			'interests' => $interests,
		];
		return $params;
	}
}
