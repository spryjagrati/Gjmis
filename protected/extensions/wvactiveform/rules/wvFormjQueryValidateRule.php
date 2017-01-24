<?php
/**
 * wvFormjQueryValidateRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * jQuery.Validate rule.
 * 
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormjQueryValidateRule extends wvFormRule
{
	/**
	 * @var string String that is added to the jQuery.validation JSON parameters.
	 * This string must be a valid JSON object notation. For example, this makes it
	 * compatible with the default Yii error classes:
	 * <pre>
	 * errorLabelContainer: ".errorMessage li",
	 * errorContainer: ".errorMessage",
	 * wrapper: "li",
	 * </pre>
	 *
	 * Get all parameters at {@see http://docs.jquery.com/Plugins/Validation}.
	 */
	public $optionsCode = '';

	private $rules = array();
	private $messages = array();

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
			// javascript has custom changes, can't use minified one
/*
			if (!$form->debug)
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.validate.min.js');
			else
*/
				$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.validate.js');
			$cs->registerScriptFile($form->assetsBaseUrl.'/jquery.validate.additional-methods.js');
		}
	}

	/**
	 * Adds a jQuery.Validate rule.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string jQuery.Validation rule name
	 * @param mixed jQuery.Validation rule parameter
	 * @param string error message, if blank the default jQuery.Validation message will be used.
	 */
	public function addRule($id, $name, $rule, $value, $message = '')
	{
		if (!isset($this->rules[$name]))
			$this->rules[$name]=array();
		if ($message != '')
			if (!isset($this->messages[$name]))
				$this->messages[$name]=array();
		$this->rules[$name][$rule]=$value;
		if ($message != '')
			$this->messages[$name][$rule]=$message;
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
$("#{$form->id}").validate({
rules: {$this->optionsRules},
messages: {$this->optionsMessages},
{$this->getIgnoreFields($form)}
{$this->optionsCode}
});

EOD;
	}

	/**
	 * Returns a JSON string of the "rules" parameter of jQuery.Validation
	 * @return string
	 */
	public function getOptionsRules()
	{
		return $this->rules===array()?'{}' : CJavaScript::encode($this->rules, true);
	}

	/**
	 * Returns a JSON string of the "messages" parameter of jQuery.Validation
	 * @return string
	 */
	public function getOptionsMessages()
	{
		return $this->messages===array()?'{}' : CJavaScript::encode($this->messages, true);
	}

	/**
	 * Returns a JSON string of the "ignore" parameter of jQuery.Validation
	 * @return string
	 */
	public function getIgnoreFields($form)
	{
		if (count($form->ignoreFields) > 0)
			return 'ignore: "'.implode(', ', $form->ignoreFields)."\",\n";
		return '';
	}
}
?>
