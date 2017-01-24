<?php
/**
 * wvFormRule class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Validation rule base class.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormRule extends CComponent
{
	/**
	 * @var array list of built-in rules (name=>class)
	 */
	public static $builtInRules=array(
		'validate'=>'wvFormjQueryValidateRule',
		'numeric'=>'wvFormjQueryNumericRule',
		'defaultValue'=>'wvFormjQueryDefaultValueRule',
		'keyFilter'=>'wvFormjQueryKeyFilterRule',
		'custom'=>'wvFormCustomRule',
	);

	/**
	 * A function with this signature must exist in all derived classes
	 */
	//abstract public function addRule($id, $name)

	/**
	 * Register the used script files.
	 *
	 * @param wvActiveForm form
	 */
	public function registerScripts($form)
	{
		
	}

	/**
	 * Returns the validation script code.
	 *
	 * @param wvActiveForm form
	 * @return string the validation code
	 */
	public function returnScriptCode($form)
	{
		return '';
	}

	/**
	 * Creates the rule object.
	 *
	 * @param string rule class name or alias
	 * @param mixed rule parameters
	 * @return wvFormRule the rule object
	 */
	public static function createRule($name, $params = array())
	{
		if (!is_array($params))
			$params=array('defaultValue'=>$params);

		if(isset(self::$builtInRules[$name]))
			$className=Yii::import(self::$builtInRules[$name],true);
		else
			$className=Yii::import($name,true);
		return Yii::createComponent(CMap::mergeArray(array('class'=>$className), $params));
	}

	/**
	 * Translate rule aliases into class names.
	 *
	 * @param string rule class name or alias
	 * @return string rule class name
	 */
	public static function translateRuleName($name)
	{
		if(isset(self::$builtInRules[$name]))
			return self::$builtInRules[$name];
		else
			return $name;
	}
	
}
?>
