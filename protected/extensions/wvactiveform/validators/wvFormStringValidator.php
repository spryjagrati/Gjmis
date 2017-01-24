<?php
/**
 * wvFormStringValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Validates a string for length.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormStringValidator extends wvFormValidator
{
	/**
	 * @var integer maximum length. Defaults to null, meaning no maximum limit.
	 */
	public $max;
	/**
	 * @var integer minimum length. Defaults to null, meaning no minimum limit.
	 */
	public $min;
	/**
	 * @var integer exact length. Defaults to null, meaning no exact length limit.
	 */
	public $is;
	/**
	 * @var string user-defined error message used when the value is too long.
	 */
	public $tooShort;
	/**
	 * @var string user-defined error message used when the value is too short.
	 */
	public $tooLong;

	/**
	 * Constructor, optionally importing a CStringValidator.
	 *
	 * @param CStringValidator validator to import
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
		if ($this->min != null)
		{
			$message=$this->tooShort!==null?$this->tooShort:Yii::t('yii','{attribute} is too short (minimum is {min} characters).', array(
				'{attribute}'=>$attributeName, '{min}'=>$this->min,
			));
			$rules->addValidateRule($id, $name, 'minlength', $this->min, $message);
		}
		if ($this->max != null)
		{
			$message=$this->tooLong!==null?$this->tooLong:Yii::t('yii','{attribute} is too long (maximum is {max} characters).', array(
				'{attribute}'=>$attributeName, '{max}'=>$this->max,
			));
			$rules->addValidateRule($id, $name, 'maxlength', $this->max, $message);
		}
		if ($this->is != null)
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} is of the wrong length (should be {length} characters).', array(
				'{attribute}'=>$attributeName, '{length}'=>$this->is,
			));
			$rules->addValidateRule($id, $name, 'rangelength', array($this->is, $this->is), $message);
		}
	}

	/**
	 * Imports a CStringValidator.
	 */
	public function import(CValidator $validator)
	{
		if ($validator instanceof CStringValidator)
		{
			$this->message = $validator->message;
			$this->max = $validator->max;
			$this->min = $validator->min;
			$this->is = $validator->is;
			$this->tooShort = $validator->tooShort;
			$this->tooLong = $validator->tooLong;
		}
		else
			parent::import($validator);
	}
}
?>
