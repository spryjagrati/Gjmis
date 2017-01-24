<?php
/**
 * wvFormDefaultValueValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Adds a default value to the field, that is hidden when
 * the user clicks on it.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormDefaultValueValidator extends wvFormValidator
{
	/**
	 * @var string default value
	 */
	public $value;

	/**
	 * Default value setter
	 */
	public function setDefaultValue($value)
	{
		$this->value = $value;
	}

	/**
	 * Creates the rule.
	 */
	public function createRule($rules, $id, $name, $attributeName)
	{
		$rules->addDefaultValueRule($id, $name, $this->value);
	}
}
?>
