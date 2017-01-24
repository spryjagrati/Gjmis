<?php
/**
 * wvFormRules class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Consolidates and generates all rules codes.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormRules extends CComponent
{
	/**
	 *
	 * @var array rules parameters, to be passed when creating the rule class.
	 * Should be an associative array where the index is the rule class name,
	 * NOT the rule alias.
	 */
	public $rulesParams = array();

	private $rules = array();


	/**
	 * Magic method to allow for a function call in the format:
	 *
	 * add<rulename>Rule(...)
	 *
	 * which is the same as calling
	 *
	 * addRule(rulename, ...)
	 *
	 * For example:
	 *
	 * addValidateRule($id, $name, 'required', true, $message);
	 */
	public function  __call($name, $arguments)
	{
		// add[rulename]Rule
		if (substr($name, 0, 3) == 'add' && substr($name, -4) == 'Rule')
		{
			$ruleName=substr($name, 3, strlen($name)-7);
			if (strlen($ruleName) == 0)
				return parent::__call($name, $arguments);
			
			// PHP < 5.3 doesn't have lcfirst
			$ruleName[0] = strtolower($ruleName[0]);
			$callArg = CMap::mergeArray(array($ruleName), $arguments);

			call_user_func_array(array($this, 'addRule'), $callArg);
			return;
		}
		return parent::__call($name, $arguments);
	}

	/**
	 * Adds a rule. More parameters can (or must) be passed depending on the rule.
	 *
	 * @param string rule class name or alias
	 * @param string element id
	 * @param string input name
	 */
	public function addRule($rule, $id, $name)
	{
		$params=func_get_args();
		array_shift($params);
		call_user_func_array(array($this->getRule($rule, true), 'addRule'), $params);
	}

	/**
	 * Returns a rule object for the specified rule, optionally creating it if necessary.
	 *
	 * @param string rule class name or alias
	 * @param boolean wether to create the rule object if it does not exists
	 * @return wvFormRule rule object, or null if not found
	 */
	public function getRule($rule, $create = false)
	{
		if (isset($this->rules[$rule]))
			return $this->rules[$rule];
		if ($create)
		{
			$rname=wvFormRule::translateRuleName($rule);
			$rparams=isset($this->rulesParams[$rname])?$this->rulesParams[$rname]:array();
			$this->rules[$rule]=wvFormRule::createRule($rule, $rparams);
			return $this->rules[$rule];
		}
		return null;
	}

	/**
	 * Register the used script files.
	 *
	 * @param wvActiveForm form
	 */
	public function registerScripts($form)
	{
		foreach ($this->rules as $rule)
			$rule->registerScripts($form);
	}

	/**
	 * Returns the validation script code.
	 *
	 * @param wvActiveForm form
	 * @return string the validation code
	 */
	public function returnScriptCode($form)
	{
		$script='';
		foreach ($this->rules as $rule)
			$script.=$rule->returnScriptCode($form);
		return $script;
	}
}
?>
