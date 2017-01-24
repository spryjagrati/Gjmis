<?php
/**
 * wvFormNumberValidator class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */

/**
 * Numeric validator.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvFormNumberValidator extends wvFormValidator
{
	/**
	 * @var boolean whether the attribute value can only be an integer. Defaults to false.
	 */
	public $integerOnly=false;
	/**
	 * @var integer|double upper limit of the number. Defaults to null, meaning no upper limit.
	 */
	public $max;
	/**
	 * @var integer|double lower limit of the number. Defaults to null, meaning no lower limit.
	 */
	public $min;
	/**
	 * @var string user-defined error message used when the value is too big.
	 */
	public $tooBig;
	/**
	 * @var string user-defined error message used when the value is too small.
	 */
	public $tooSmall;

	/**
	 * Constructor, optionally importing a CNumberValidator.
	 *
	 * @param CNumberValidator validator to import
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
		$rules->addNumericRule($id, $name, $this->integerOnly);
		if ($this->integerOnly)
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be an integer.', array(
				'{attribute}'=>$attributeName,
			));
			$rules->addValidateRule($id, $name, 'integer', true, $message);
		}
/*
		else
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} must be a number.', array(
				'{attribute}'=>$attributeName,
			));
			$rules->addValidateRule($id, $name, 'number', true, $message);
		}
*/
		if ($this->min != null)
		{
			$message=$this->tooSmall!==null?$this->tooSmall:Yii::t('yii','{attribute} is too small (minimum is {min}).', array(
				'{attribute}'=>$attributeName, '{min}'=>$this->min,
			));
			$rules->addValidateRule($id, $name, 'min', $this->min, $message);
		}
		if ($this->max != null)
		{
			$message=$this->tooBig!==null?$this->tooBig:Yii::t('yii','{attribute} is too big (maximum is {max}).', array(
				'{attribute}'=>$attributeName, '{max}'=>$this->max,
			));
			$rules->addValidateRule($id, $name, 'max', $this->max, $message);
		}
	}

	/**
	 * Imports a CNumberValidator.
	 */
	public function import(CValidator $validator)
	{
		if ($validator instanceof CNumberValidator)
		{
			$this->message = $validator->message;
			$this->integerOnly = $validator->integerOnly;
			$this->max = $validator->max;
			$this->min = $validator->min;
			$this->tooSmall = $validator->tooSmall;
			$this->tooBig = $validator->tooBig;
		}
		else
			parent::import($validator);
	}
}
?>
