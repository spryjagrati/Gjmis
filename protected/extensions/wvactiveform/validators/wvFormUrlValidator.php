<?php
/**
 * wvFormUrlValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Url validator.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormUrlValidator extends wvFormValidator
{
	/**
	 * Constructor, optionally importing a CUrlValidator.
	 *
	 * @param CUrlValidator validator to import
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
		$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} is not a valid URL.', array(
			'{attribute}'=>$attributeName
		));
		$rules->addValidateRule($id, $name, 'url', true, $message);
	}

	/**
	 * Imports a CUrlValidator.
	 */
	public function import(CValidator $validator)
	{
		if ($validator instanceof CUrlValidator)
		{
			$this->message = $validator->message;
		}
		else
			parent::import($validator);
	}
}
?>
