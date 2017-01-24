<?php
/**
 * wvFormEmailValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Email field validator.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormEmailValidator extends wvFormValidator
{
	/**
	 * Constructor, optionally importing a CEmailValidator.
	 *
	 * @param CEmailValidator validator to import
	 */
	public function __construct($validator = null)
	{
		//parent::__construct();
		if ($validator !== null)
			$this->import($validator);
	}

	/**
	 * Creates the rule.
	 */
	public function createRule($rules, $id, $name, $attributeName)
	{
		$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} is not a valid email address.', array(
			'{attribute}'=>$attributeName
		));
		$rules->addValidateRule($id, $name, 'email', true, $message);
	}

	/**
	 * Imports a CEmailValidator.
	 */
	public function import(CValidator $validator)
	{
		if ($validator instanceof CEmailValidator)
		{
			$this->message = $validator->message;
		}
		else
			parent::import($validator);
	}
}
?>
