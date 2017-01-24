<?php
/**
 * wvFormjQueryDefaultValueRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * jQuery.defaultValue rule.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormjQueryDefaultValueRule extends wvFormRule
{
	private $rules = array();

	/**
	 * Register the used script files.
	 *
	 * @param wvActiveForm form
	 */
	public function registerScripts($form)
	{
		if (count($this->rules) > 0)
		{
			$cs=Yii::app()->getClientScript();

			if (!$form->debug)
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.defaultvalue.js');
			else
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.defaultvalue.source.js');
		}
	}

	/**
	 * Adds a jQuery.defaultValue rule.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string the default value
	 */
	public function addRule($id, $name, $value)
	{
		$this->rules[]="$('#{$id}').defaultValue({value: '{$value}'});";
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
