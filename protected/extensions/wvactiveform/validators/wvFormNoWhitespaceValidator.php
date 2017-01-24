<?php
/**
 * wvFormNoWhitespaceValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Disallows whitespace on the field.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormNoWhitespaceValidator extends wvFormValidator
{
	/**
	 * Creates the rule.
	 */
	public function createRule($rules, $id, $name, $attributeName)
	{
		$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} is invalid.', array(
			'{attribute}'=>$attributeName
		));
		$rules->addValidateRule($id, $name, 'nowhitespace', true, $message);
		$rules->addKeyFilterRule($id, $name, 'alphanum');
	}
}
?>
