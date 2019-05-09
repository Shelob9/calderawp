<?php


namespace something\Mailchimp\Endpoints;


use calderawp\caldera\Http\Exception;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use Mailchimp\MailchimpAPIException;
use something\Mailchimp\Controllers\CreateSubscriber;
use something\Mailchimp\Controllers\FindMergeFields;
use something\Mailchimp\Entities\Groups;
use something\Mailchimp\Entities\MergeVars;
use something\Mailchimp\Entities\SingleList;
use something\Mailchimp\Entities\SubscribeGroups;
use something\Mailchimp\Entities\SubscribeMergeVars;
use something\Mailchimp\Entities\Subscriber;

abstract class AddSubscriber extends MailchimpProxyEndpoint
{
	/**
	 * @var SingleList
	 */
	protected $list;

	/** @var Groups */
	protected $groups;
	/** @var MergeVars */
	protected $mergeFields;
	/** @inheritdoc */
	public function  getUri(): string
	{
		return self::BASE_URI . '/lists/subscribe';
	}

	/** @inheritdoc */
	public function getHttpMethod(): string
	{
		return 'POST';
	}


	/** @inheritdoc */
	public function getArgs(): array
	{
		return [
			'listId' => [
				'type' => 'string',
				'required' => true
			],
			'status' => [
				'type' => 'string',
				'required' => false,
				'default' => 'subscribed'
			],
			'email' => [
				'type' => 'string',
				'required' => true
			],
			'mergeFields' => [
				'required' => true,
				'validate_callback' => function($param, $request, $key) {
					return is_array($param);
				}
			],
			'groupFields' => [
				'required' => false,
				'validate_callback' => function($param, $request, $key) {
					return is_array($param);
				},
				'sanitize_callback' =>function($groupFields) {
					return$groupFields;
				},
			],
		];
	}

	/** @inheritdoc */
	public function handleRequest(Request $request): Response
	{
		try{
			$listId = $request->getParam('listId');
			$this->setList($listId);
		}catch (\Exception $e ){
			return (new \something\Mailchimp\Endpoints\Response())->setStatus($e->getCode())->setData([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}

		try {
			$subscriber = $this->setupSubscriber($request);
		} catch (\something\Mailchimp\Exception $e) {
			return (new \something\Mailchimp\Endpoints\Response())->setStatus($e->getCode())->setData([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}

		try {
			$data = $this->getController()->__invoke($subscriber,$subscriber->getListId(),$subscriber->getStatus());
		} catch (\Exception $e) {
			return (new \something\Mailchimp\Endpoints\Response())->setStatus($e->getCode())->setData([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}

		return (new \something\Mailchimp\Endpoints\Response())->setStatus(200)->setData($data);
	}

	 protected function setList(string $listId): void {
		$this->getController()->getSavedList($listId);
	 }
	/**
	 * @param SingleList $list
	 */
	protected function setGroups(SingleList $list): void
	{
		$this->groups = $list->getGroupFields();
	}

	/**
	 * @param SingleList $list
	 */
	protected function setMergeVars(SingleList $list): void
	{
		$this->mergeFields = $list->getMergeFields();
	}

	/**
	 * @param Request $request
	 *
	 * @return Subscriber
	 * @throws \something\Mailchimp\Exception
	 */
	public function setupSubscriber(Request $request): Subscriber
	{

		$this->setMergeVars($this->list);
		$this->setGroups($this->list);
		$status = $request->getParam('status');
		$email = $request->getParam('email');
		$mergeValues = $request->getParam('mergeFields');
		$groupValues = (array)$request->getParam('groupFields');
		if (empty($groupValues)) {
			$groupValues = [];
		}

		$subscribeVars = (new SubscribeMergeVars())
			->setMergeVars($this->mergeFields)
			->setMergeValues($mergeValues);
		$subscribeGroups = (new SubscribeGroups())
			->setGroups($this->groups)
			->setGroupsJoins($groupValues);
		/** @var Subscriber $subscriber */
		$subscriber = Subscriber::fromArray([
			'groups' => $this->groups,
			'mergeFields' => $this->mergeFields,
			'email' => $email,
			'status' => $status,
		]);
		$subscriber->setListId($listId);
		$subscriber->setSubscribeMergeVars($subscribeVars);
		$subscriber->setSubscribeGroups($subscribeGroups);
		return $subscriber;
	}
}
