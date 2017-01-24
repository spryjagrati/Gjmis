<?php
/**
 * wvFormValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Base wvActiveForm validator class.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormValidator extends CComponent
{
	/**
	 * @var array list of built-in validators (name=>class)
	 */
	public static $builtInValidators=array(
		'required'=>'wvFormRequiredValidator',
		'email'=>'wvFormEmailValidator',
		'url'=>'wvFormUrlValidator',
		'length'=>'wvFormStringValidator',
		'numerical'=>'wvFormNumberValidator',
		'default'=>'wvFormDefaultValueValidator',
		'nowhitespace'=>'wvFormNoWhitespaceValidator',
		'manual'=>'wvFormManualValidator',
	);

	/**
	 * @var string the user-defined error message. Different validators may define various
	 * placeholders in the message that are to be replaced with actual values. All validators
	 * recognize "{attribute}" placeholder, which will be replaced with the label of the attribute.
	 */
	public $message;

	/**
	 * Validators should override this class to create the rules into the passed
	 * $rules object.
	 *
	 * @param wvFormRules rules class
	 * @param string element id
	 * @param string input name
	 * @param string attribute name (title)
	 */
	public function createRule($rules, $id, $name, $attributeName)
	{
		
	}

	/**
	 * Import the rules from a compatible CValidator.
	 * If the validator is not compatible, an exception is thrown.
	 *
	 * @param CValidator model validator to import
	 */
	public function import(CValidator $validator)
	{
		throw new CException('Invalid validator for this component.');
	}

	/**
	 * If the rule is passed a value instead of an array for configuration,
	 * this value is passed to this funciont.
	 *
	 * @param mixed default value
	 */
	public function setDefaultValue($value)
	{
		
	}

	/**
	 * Creates the validator object.
	 *
	 * @param string validator class name or alias
	 * @param mixed validator parameters
	 * @return wvFormValidator the validator object
	 */
	public static function createValidator($name, $params)
	{
		if (!is_array($params))
			$params=array('defaultValue'=>$params);

		if(isset(self::$builtInValidators[$name]))
			$className=Yii::import(self::$builtInValidators[$name],true);
		else
			$className=Yii::import($name,true);
		return Yii::createComponent(CMap::mergeArray(array('class'=>$className), $params));
	}

	/**
	 * Translate validator aliases into class names.
	 *
	 * @param string validator class name or alias
	 * @return string validator class name
	 */
	public static function translateValidatorName($name)
	{
		if(isset(self::$builtInValidators[$name]))
			return self::$builtInValidators[$name];
		else
			return $name;
	}
}
?>
