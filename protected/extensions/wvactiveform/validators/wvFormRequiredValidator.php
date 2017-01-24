<?php
/**
 * wvFormRequiredValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Makes the field required.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormRequiredValidator extends wvFormValidator
{
	/**
	 * Constructor, optionally importing a CRequiredValidator.
	 *
	 * @param CRequiredValidator validator to import
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
		$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} cannot be blank.', array('{attribute}'=>$attributeName));
		$rules->addValidateRule($id, $name, 'required', true, $message);
	}

	/**
	 * Imports a CRequiredValidator.
	 */
	public function import(CValidator $validator)
	{
		if ($validator instanceof CRequiredValidator)
			$this->message=$validator->message;
		else
			parent::import($validator);
	}
}
?>
