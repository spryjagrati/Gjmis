<?php
/**
 * wvFormjQueryKeyFilterRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * jQuery.keyFilter rule.
 * 
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormjQueryKeyFilterRule extends wvFormRule
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
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.keyfilter-1.7.min.js');
			else
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.keyfilter-1.7.js');
		}
	}

	/**
	 * Adds a jQuery.keyFilter rule.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string filter name or regexp mask
	 */
	public function addRule($id, $name, $rule)
	{
		if (substr($rule, 0, 1)!=='/')
			$rule='$.fn.keyfilter.defaults.masks.'.$rule;

		$this->rules[]="$('#{$id}').keyfilter({$rule});";
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
