<?php
include_once __DIR__ . '/vendor/autoload.php';
//$dotenv = Dotenv\Dotenv::create(__DIR__);
//$dotenv->load();


$listId = '45907f0c59';
$categoryId = '50c908e6aa';
$mailchimp = new \Mailchimp\MailchimpLists('48a03b014a447b79e577cdbf03a8337f-us3');
$account = $mailchimp->getInterestCategories('45907f0c59','be5e6673ca');
file_put_contents('interest.json', json_encode($account) );exit;
$x = (new \something\Mailchimp\Controllers\GetCategories($mailchimp))->__invoke($listId,$categoryId);
echo json_encode($x);exit;


	return;

$list = (new \something\Mailchimp\GetGroup($mailchimp))->__invoke($listId,'50c908e6aa');

echo json_encode($list);exit;
$r = $mailchimp
	->lists()
	->get();
$body = json_decode($r->getBody() );
$lists = $body->lists;
foreach ( $lists as $list ){
	var_dump($list->id);exit;
	$r = $mailchimp->lists( $list->id )->mergeFields()->get();
	$body = json_decode($r->getBody());
	$mergeFields = $body->merge_fields;
	var_dump($mergeFields);exit;
	$r = $mailchimp->lists( $list->id )->interestCategories()->get();
	$body = json_decode($r->getBody());
	$intrestCategories = $body->categories;
	$r = $mailchimp->automations()->get();
	$body = json_decode($r->getBody());
	var_dump($body->automations);
}




