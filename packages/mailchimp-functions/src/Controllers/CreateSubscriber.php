<?php


namespace something\Mailchimp\Controllers;


use Mailchimp\MailchimpAPIException;
use something\Mailchimp\Entities\Account;
use something\Mailchimp\Entities\SingleList;
use something\Mailchimp\Entities\Subscriber;

abstract class CreateSubscriber extends MailchimpProxy
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
		$params = $this->prepareParams($subscriber, $status);
		try{
			$response =$this->getMailchimp()
				->addMember($listId, $subscriber->getEmail(),$params);
            return $this->createResponse($response);

		}catch (MailchimpAPIException $e){
			if( 0 === strpos($e->getMessage(),'400: Member Exists') ){
				$response =$this->getMailchimp()
					->updateMember($listId, $subscriber->getEmail(),$params);
                return $this->createResponse($response);
			}else{
			    throw $e;
            }
		}

        return $this->createResponse($response);
    }

	abstract public function getSavedList(string $listId ): SingleList;
	abstract public function getSavedAccount(SingleList $list ): Account;

    /**
     * @param object $response
     * @return array
     */
    public function createResponse(object $response): array
    {
        return [
            'success' => true,
            'message' => 'Subscription Successful',
            'status' => $response->status,
            'id' => $response->id
        ];
    }


}
