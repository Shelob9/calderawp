<?php


namespace something\Mailchimp\Controllers;


use Mailchimp\MailchimpAPIException;
use something\Mailchimp\Endpoints\AddSubscriber;
use something\Mailchimp\Entities\Subscriber;

class UpdateSubscriber  extends MailchimpProxy
{
	use HandlesSubscriptionParams;
	/**
	 * @param Subscriber $subscriber
	 * @param string $listId
	 * @param string $status
	 *
	 * @return array
	 */
	public function __invoke(Subscriber $subscriber, string $listId, string $status = 'subscribed') :array
	{
		$params = $this->prepareParams($subscriber,$status);
				$response =$this->getMailchimp()
					->updateMember($listId, $subscriber->getEmail(),$params);


		return [
			'success' => true,
			'message' => 'Subscription Successful',
			'status' => $response->status,
			'id' => $response->id
		];
	}



}
