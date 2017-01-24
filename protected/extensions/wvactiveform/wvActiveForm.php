<?php
/**
 * wvActiveForm class file.
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2010 Rangel Reale
 * @license http://www.yiiframework.com/license/
 */
require_once('wvFormValidator.php');
require_once('wvFormRule.php');
require_once('wvFormRules.php');
require_once('wvFormLayout.php');

require_once('rules/inc_rules.php');
require_once('validators/inc_validators.php');

/**
 * wvActiveForm provides a set of methods that can facilitate creating a form associated with some data models,
 * with client-side validation.
 *
 * wvActiveForm automatically uses the model's validation rules, and also allows for
 * manual validation setting.
 *
 * The 'htmlOptions' parameter accepts 2 extra parameters on all fields:
 * <ul>
 * <li>disableValidation: if true, disables validation on this field.</li>
 * <li>validators: associative array of validation class => validation parameters, for example,
 * <pre>
 *     'validators'=>array(
 *         'required'=>true,
 *         'wvFormStringValidator'=>array('max'=>100),
 *     );
 * </pre>
 * </li>
 * </ul>
 *
 * To adapt the validation error output to your layout, you will probably want to
 * set {@link wvFormjQueryValidateRule::optionsCode} to configure
 * jQuery.Validation ({@link http://docs.jquery.com/Plugins/Validation}), and
 * maybe {@link wvActiveForm::error} and {@link wvActiveForm::errorSummary} to
 * output compatible error containers.
 *
 * @see CActiveForm
 *
 * @author Rangel Reale <rangelreale@gmail.com>
 * @package wvActiveForm
 */
class wvActiveForm extends CActiveForm
{
	/**
	 * Field options.
	 */
	const FO_IGNORE_HIDDEN		= 1; // ignore hidden Yii CHtml fields

	/**
	 * @var boolean debug mode. When in debug mode, uses the non-min jquery javascripts.
	 */
	public $debug = false;

	/**
	 * @var boolean wether to do client validation
	 */
	public $clientValidation = true;

	/**
	 * @var array rules parameters, to be passed when creating the rule class.
	 * Should be an associative array where the index is the rule class name,
	 * NOT the rule alias.
	 */
	public $rulesParams = array();

	/**
	 * Fields to ignore on validation. Yii adds some hidden fields on checkboxes
	 * and radiobuttons, and they get in the way of validation.
	 * 
	 * @var array list of jQuery selectors to ignore
	 */
	public $ignoreFields = array();

	/**
	 * @var string layout class name or alias
	 */
	public $layoutName;

	/**
	 * @var array layout class parameters
	 */
	public $layoutParams = array();

	private $validations = array();
	private $layout;
	protected $baseUrl;

	/**
	 * Initializes the widget.
	 * This method registers all needed client scripts.
	 */
	public function init()
	{
		parent::init();

      	$dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
      	$this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

  		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');

		// layout class support
		if ($this->layoutName !== null)
		{
			$this->layout = wvFormLayout::createLayout($this,
				$this->layoutName, $this->layoutParams);

			$this->layout->init();
		}
		else
			$this->layout = null;
	}


	/**
	 * Do layout processing.
	 */
	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true)
	{
		if (isset($this->layout))
		{
			$ret=$this->layout->error($model, $attribute, $htmlOptions, $enableAjaxValidation);
			if ($ret !== false)
				return $ret;
		}
		return parent::error($model, $attribute, $htmlOptions, $enableAjaxValidation);
	}

	/**
	 * Do layout processing.
	 */
	public function errorSummary($model,$header=null,$footer=null,$htmlOptions=array())
	{
		if (isset($this->layout))
		{
			$ret=$this->layout->errorSummary($model,$header,$footer,$htmlOptions);
			if ($ret !== false)
				return $ret;
		}
		return parent::errorSummary($model,$header,$footer,$htmlOptions);
	}

	/**
	 * Adds validation for fields not created by this class.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function externalField($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return '';
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function textField($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return parent::textField($model,$attribute,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function passwordField($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return parent::passwordField($model,$attribute,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function textArea($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return parent::textArea($model,$attribute,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function radioButton($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions,array(self::FO_IGNORE_HIDDEN));
		return parent::radioButton($model,$attribute,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function checkBox($model,$attribute,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions,array(self::FO_IGNORE_HIDDEN));
		return parent::checkBox($model,$attribute,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function dropDownList($model,$attribute,$data,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return parent::dropDownList($model,$attribute,$data,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function listBox($model,$attribute,$data,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions);
		return parent::listBox($model,$attribute,$data,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function checkBoxList($model,$attribute,$data,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions,array(self::FO_IGNORE_HIDDEN));
		return parent::checkBoxList($model,$attribute,$data,$htmlOptions);
	}

	/**
	 * Returns the field and creates the validation rules.
	 * Please check {@link CActiveForm::textField} for detailed information
	 * about the parameters for this method.
	 */
	public function radioButtonList($model,$attribute,$data,$htmlOptions=array())
	{
		$this->checkValidation($model,$attribute,$htmlOptions,array(self::FO_IGNORE_HIDDEN));
		return parent::radioButtonList($model,$attribute,$data,$htmlOptions);
	}

	/**
	 * Checks the validations for the field.
	 *
	 * @param CModel moodel
	 * @param string attribute
	 * @param array html options
	 * The following HTML option is recognized:
	 * <ul>
	 * <li>disableValidation: if true, disables validation on this field.</li>
	 * <li>validators: associative array of validation class => validation parameters, for example,
	 * <pre>
	 *     'validators'=>array(
	 *         'required'=>true,
	 *         'wvFormStringValidator'=>array('max'=>100),
	 *     );
	 * </pre>
	 * </li>
	 * </ul>
	 */
	protected function checkValidation($model,$attribute,&$htmlOptions=array(),
		$fieldOptions=array())
	{
		if (isset($htmlOptions['disableValidation']))
		{
			unset($htmlOptions['disableValidation']);
			return;
		}

		CHtml::resolveNameID($model,$attribute,$htmlOptions);
		$attributeName = $model->getAttributeLabel($attribute);

		foreach ($fieldOptions as $fopt)
			switch($fopt)
			{
			case self::FO_IGNORE_HIDDEN:
				$this->ignoreFields[]="#".CHtml::ID_PREFIX."{$htmlOptions['id']}";
				break;
			}

		foreach ($model->getValidators($attribute) as $validator)
			$this->addValidationForValidator($htmlOptions['id'], $htmlOptions['name'], $attributeName, $validator);

		if (isset($htmlOptions['validators']))
		{
			foreach ($htmlOptions['validators'] as $vname => $vdata)
				$this->addValidationByName($htmlOptions['id'], $htmlOptions['name'], $attributeName,
					$vname, $vdata);

			unset($htmlOptions['validators']);
		}
	}

	/**
	 * Adds a validator to a field.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string attribute name (title) for messages
	 * @param wvFormValidator validator object
	 */
	public function addValidation($id, $name, $attributeName, wvFormValidator $validator)
	{
		if (!isset($this->validations[$id]))
			$this->validations[$id]=array();
		$this->validations[$id][get_class($validator)]=array('id'=>$id, 'name'=>$name, 'attributeName'=>$attributeName, 'validator'=>$validator);
	}

	/**
	 * Returns the current validation rules for the field.
	 *
	 * @param string element id
	 * @param string input name
	 * @param srting validation class name or alias. If null, all validations are returned
	 * @return array the validation rules
	 */
	public function getValidation($id, $name, $validationName = null)
	{
		if (!isset($this->validations[$id]))
			return null;
		if ($validationName === null)
			return $this->validations[$id];

		$validationName = wvFormValidator::translateValidatorName($validationName);

		if (!isset($this->validations[$id][$validationName]))
			return null;
		return $this->validations[$id][$validationName];
	}

	/**
	 * Adds a validator to a field, using validator name.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string  attribute name (title) for messages
	 * @param string validator name (wvFormValidator-descendant class name or built in id)
	 * @param array validator parameters
	 */
	public function addValidationByName($id, $name, $attributeName, $validationName, $params = array())
	{
		if ($params === false)
		{
			$this->deleteValidation($id, $name, $validationName);
			return;
		}
		$this->addValidation($id, $name, $attributeName, wvFormValidator::createValidator($validationName, $params));
	}

	/**
	 * Adds a validator to a field, based on a CValidator.
	 *
	 * @param string element id
	 * @param string input name
	 * @param string  attribute name (title) for messages
	 * @param CValidator the model validator to import
	 * @return boolean true if the validation was imported
	 */
	public function addValidationForValidator($id, $name, $attributeName, CValidator $validator)
	{
		// REQUIRED
		if ($validator instanceof CRequiredValidator)
		{
			$this->addValidation($id, $name, $attributeName, new wvFormRequiredValidator($validator));
			return true;
		}
		// STRING
		elseif ($validator instanceof CStringValidator)
		{
			$this->addValidation($id, $name, $attributeName, new wvFormStringValidator($validator));
			return true;
		}
		// NUMBER
		elseif ($validator instanceof CNumberValidator)
		{
			$this->addValidation($id, $name, $attributeName, new wvFormNumberValidator($validator));
			return true;
		}
		// EMAIL
		elseif ($validator instanceof CEmailValidator)
		{
			$this->addValidation($id, $name, $attributeName, new wvFormEmailValidator($validator));
			return true;
		}
		// URL
		elseif ($validator instanceof CUrlValidator)
		{
			$this->addValidation($id, $name, $attributeName, new wvFormUrlValidator($validator));
			return true;
		}

		return false;
	}

	/**
	 * Deletes a validation.
	 * @param string element id
	 * @param string input name
	 * @param string validation name (validator class name or built-in alias)
	 */
	public function deleteValidation($id, $name, $validationName)
	{
		$validationName = wvFormValidator::translateValidatorName($validationName);

		if (isset($this->validations[$id]) && isset($this->validations[$id][$validationName]))
		{
			unset($this->validations[$id][$validationName]);
		}
	}

	/**
	 * Ends running the widget.
	 * This registers the necessary javascript code and renders the form close tag
	 * and javascript validation.
	 */
	public function run()
	{
		if (isset($this->layout))
			$this->layout->beforeRun();

		parent::run();

		if ($this->clientValidation)
		{
			$rules = new wvFormRules;
			$rules->rulesParams = $this->rulesParams;

			// process the validations into jQuery code
			foreach ($this->validations as $validationId => $validation)
				foreach ($validation as $validationClass => $validationData)
					$validationData['validator']->createRule($rules, $validationData['id'], $validationData['name'], $validationData['attributeName']);

			$rules->registerScripts($this);

			$script=$rules->returnScriptCode($this);
			if ($script != '')
				Yii::app()->clientScript->registerScript('wvactiveform-'.$this->id,
					$script, CClientScript::POS_READY);
		}

		if (isset($this->layout))
			$this->layout->afterRun();
	}

	/**
	 * Returns the built-in validators assets path
	 */
	public function getAssetsBaseUrl()
	{
		return $this->baseUrl;
	}
}
?>