<?php
/**
 * wvFormCustomRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Custom javascript rule.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormCustomRule extends wvFormRule
{
	private $rules = array();

	/**
	 * Adds a custom rule.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string rule
	 */
	public function addRule($id, $name, $rule)
	{
		$this->rules[]=$rule;
	}

	/**
	 * Returns the validation script code.
	 *
	 * @param wvActiveForm form
	 * @return string the validation code
	 */
	public function returnScriptCode($form)
	{
		if (count($this->rules) == 0) return '';

		return <<<EOD
{$this->codeRules}

EOD;
	}

	/**
	 * Returns the javascript for the rules.
	 * @return string
	 */
	public function getCodeRules()
	{
		$rules='';
		foreach ($this->rules as $rule)
			$rules.=$rule."\n";
		return $rules;
	}

}
?>
