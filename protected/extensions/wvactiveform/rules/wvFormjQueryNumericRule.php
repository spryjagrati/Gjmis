<?php
/**
 * wvFormjQueryNumericRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * jQuery.numeric rule.
 * 
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormjQueryNumericRule extends wvFormRule
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
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.numeric.pack.js');
			else
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.numeric.js');
		}
	}

	/**
	 * Adds a jQuery.Numeric rule.
	 *
	 * @param string element id
	 * @param string input name
	 * @param boolean wether to accept only integer numbers
	 */
	public function addRule($id, $name, $integerOnly = false)
	{
		// setting the parameter to '1' makes numeric don't accept any decimal separator
		$this->rules[$id]="'".($integerOnly?'1':Yii::app()->locale->getNumberSymbol('decimal'))."'";
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
	 * Returns the javascript code for all jQuery.Numeric validations.
	 * @return string
	 */
	public function getCodeRules()
	{
		$rules='';
		foreach ($this->rules as $ruleId => $rule)
		{
			$rules.="$('#{$ruleId}').numeric({$rule});\n";
		}
		return $rules;
	}
}
?>
