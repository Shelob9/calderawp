<?php


namespace something\Mailchimp\Interfaces;


interface ConvertsToUiField
{

	/**
	 * Convert to UI field
	 *
	 * @return array
	 */
	public function toUiFieldConfig(): array;
}
