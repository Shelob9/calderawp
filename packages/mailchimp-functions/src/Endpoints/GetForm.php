<?php


namespace something\Mailchimp\Endpoints;

use calderawp\interop\Contracts\Rest\Endpoint as EndpointContract;

use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\Rest\RestResponseContract as Response;
use calderawp\interop\Contracts\TokenContract;
use calderawp\interop\Traits\Rest\ProvidesRestEndpoint;
use something\Mailchimp\Entities\Group;
use something\Mailchimp\Entities\MailchimpFormConfig;
use something\Mailchimp\Entities\SingleList;

abstract class GetForm implements EndpointContract
{
    use ProvidesRestEndpoint;

    /**
     * @var string
     */
    protected $submitUrl;

    /**
     * @inheritDoc
     */
    public function authorizeRequest(Request $request): bool
    {
        return !empty($this->getToken($request));
    }


    /** @inheritdoc */
    public function getUri(): string
    {
        return GetList::BASE_URI . '/forms/(?P<listId>[\w-]+)';
    }

    public function getHttpMethod(): string
    {
        return 'GET';
    }

    /** @inheritdoc */
    public function getArgs(): array
    {
        return [
            'listId' => [
                'type' => 'string',
                'required' => true
            ],
            'token' => [
                'type' => 'string',
                'required' => true
            ],
            'asUiConfig' => [
                'type' => 'boolean',
                'default' => false
            ]
        ];

    }

    /**
     * @inheritDoc
     */
    public function handleRequest(Request $request): Response
    {

        try {
            $listId = $request->getParam('listId');
            $list = $this->getListByListId($request->getParam('listId'));
            if ($request->getParam('asUiConfig')) {
                $form = new MailchimpFormConfig();
                $form->setFields($list->toUiFieldConfig());
                $form->setProcessor(
                        $this->createProcessor(
                            $listId,
                            $list->getEmailFieldId(),
                            $list->getMergeFieldIds(),
                            $list->getGroupFieldIds()
                        )
                );
                $form->setId(sprintf('mc-signup-%s',$list->getListId()));
                $form->setName($list->getName() );
                return (new \something\Mailchimp\Endpoints\Response())
                    ->setData($form->toArray())->setStatus(200);
            } else {
                return (new \something\Mailchimp\Endpoints\Response())
                    ->setData($list->toArray())->setStatus(200);
            }


        } catch (\Exception $e) {
            return (new \something\Mailchimp\Endpoints\Response())->setData(['mesage' => $e->getMessage()])->setStatus($e->getCode());
        }
    }

    public function getToken(Request $request): string
    {
        return $request->getParam('token');
    }

    protected function createProcessor(string $listId, string $emailFieldId, array $mergeFieldIds = [], array $groupFieldIds = []): array
    {
        return [
            'type' => 'mc-subscribe',
            'listId' => $listId,
            'emailField' => $emailFieldId,
            'mergeFields' => $mergeFieldIds,
            'groupFields' => $groupFieldIds,
            'submitUrl' => $this->getSubmitUrl()
        ];

    }

    /**
     * @return string
     */
    public function getSubmitUrl(): string
    {
        return $this->submitUrl;
    }

    /**
     * @param string $submitUrl
     * @return GetForm
     */
    public function setSubmitUrl(string $submitUrl): GetForm
    {
        $this->submitUrl = $submitUrl;
        return $this;
    }


    abstract protected function getListByListId(string $listId): SingleList;
}