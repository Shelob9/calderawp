<?php


namespace something\Mailchimp\Database;


use WpDbTools\Type\GenericStatement;

class Table extends \calderawp\DB\Table
{


	public function selectAll()
	{

		$tableName = $this->getTableName();

		$statement = new GenericStatement(
			"SELECT * FROM {$tableName}"
		);


		$result = $this
			->query($statement);
		return $result;
	}
}
