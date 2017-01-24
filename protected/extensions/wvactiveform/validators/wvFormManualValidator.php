<?php
/**
 * wvFormManualValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Adds validation rules manually.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormManualValidator extends wvFormValidator
{
	/**
	 * @var array list of arrays with addValidateRule method parameters
	 */
	public $validate = array();
	/**
	 * @var array list of arrays with addNumericRule method parameters
	 */
	public $numeric = array();
	/**
	 * @var array list of arrays with addDefaultValueRule method parameters
	 */
	public $defaultValue = array();
	/**
	 * @var array list of arrays with addKeyFilterRule method parameters
	 */
	public $keyFilter = array();
	/**
	 * @var array list of arrays with addExtraRule method parameters
	 */
	public $extra = array();

	/**
	 * Creates the rule.
	 */
	public function createRule($rules, $id, $name, $attributeName)
	{
		foreach ($this->validate as $rule)
			call_user_func_array(array($rules, 'addValidateRule'), array_merge(array($id, $name), $rule));

		foreach ($this->numeric as $rule)
			call_user_func_array(array($rules, 'addNumericRule'), array_merge(array($id, $name), $rule));

		foreach ($this->defaultValue as $rule)
			call_user_func_array(array($rules, 'addDefaultValueRule'), array_merge(array($id, $name), $rule));

		foreach ($this->keyFilter as $rule)
			call_user_func_array(array($rules, 'addKeyFilterRule'), array_merge(array($id, $name), $rule));

		foreach ($this->extra as $rule)
			call_user_func_array(array($rules, 'addExtraRule'), $rule);
	}
}
?>
