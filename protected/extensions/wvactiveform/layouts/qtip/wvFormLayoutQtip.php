<?php
class wvFormLayoutQtip extends wvFormLayout
{
	/**
	 * @var array JSON paramaters to be passed to .qtip({})
	 */
	public $jsOptions = array(
		'position' => array(
			'corner' => array(
				'target' => 'rightMiddle',
				'tooltip' => 'leftMiddle',
			),
		),
		'style' => array(
		   'width' => array(
			  'min' => 200,
			  'max' => 400,
		   ),
		   'padding' => 2,
		   'border' => array(
			  'width' => 3,
			  'radius' => 3,
		   ),
		   'tip' => array(
				'corner' => 'leftMiddle',
			),
		),
		'show' => array(
			'when' => false,
		),
		'hide' => array(
			'when' => array(
				'event' => 'inactive',
			),
			'delay' => 140,
		),
	);

	protected $baseUrl;

	private $hasSummary = false;
	private $summaryModels;

	/**
	 * Merges the passed options with the defaults
	 * @param array js options
	 */
	public function setMergeJsOptions($value)
	{
		$this->jsOptions = CMap::mergeArray($this->jsOptions, $value);
	}

	/**
	 * Adds jquery.Validation options
	 */
	public function init()
	{
		parent::init();
		
      	$dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
      	$this->baseUrl = Yii::app()->getAssetManager()->publish($dir);


  		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');

		$cs->registerScriptFile($this->baseUrl.'/jquery.qtip-1.0.0-rc3-dm.js');

		Yii::app()->clientScript->registerScript('wvfl_qtip_header', <<<EOD
function wvfl_qtip_showerror(element, message)
{
	var qtipapi=$(element).qtip('api');
	qtipapi.updateContent(message);
	qtipapi.show();
	$('#{$this->form->id}').data('validator').settings.highlight(element);
}

EOD
, CClientScript::POS_BEGIN);

		$this->form->rulesParams['wvFormjQueryValidateRule']=array(
			'optionsCode'=>$this->getjQueryValidationOptionsCode(),
		);
	}

	/**
	 * Always adds the error field, even if no errors, so we can manipulate it with
	 * jQuery.validate.
	 */
	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true)
	{
		if(!$this->form->enableAjaxValidation || !$enableAjaxValidation)
		{
			// do not show field errors, only summary
			$for=CHtml::getIdByName(CHtml::resolveName($model,$attribute));

			Yii::app()->clientScript->registerScript('wvfl_qtip_field_'.$for, <<<EOD
$('#$for').qtip({$this->options});

EOD
			, CClientScript::POS_READY);

			return '';
		}
		else
			return false;
	}

	/**
	 * Always adds the error summary, even if no errors, so we can manipulate it with
	 * jQuery.validate. If no errors, default to display: none.
	 */
	public function errorSummary($model,$header=null,$footer=null,$htmlOptions=array())
	{
		if(!$this->form->enableAjaxValidation)
		{
			$this->hasSummary = true;
			$this->summaryModels = $model;

			return '';
		}
		return false;
	}

	/**
	 * Show the tips for model errors.
	 */
	public function afterRun()
	{
		if ($this->form->clientValidation && $this->hasSummary)
		{
			if(!is_array($this->summaryModels))
				$model=array($this->summaryModels);
			else
				$model=$this->summaryModels;

			$esum='';
			foreach($model as $m)
			{
				foreach($m->getErrors() as $attribute => $errors)
				{
					foreach($errors as $error)
					{
						if($error!='')
						{
							$for=CHtml::getIdByName(CHtml::resolveName($m,$attribute));
							$esum.="wvfl_qtip_showerror($('#$for').first(), '$error');\n";
						}
					}
				}
			}

			if ($esum != '')
				Yii::app()->clientScript->registerScript('wvfl_qtip_startup', $esum, CClientScript::POS_READY);
		}
	}

	/**
	 * jQuery.validate options, sets the output container to be Yii-compatible.
	 */
	protected function getjQueryValidationOptionsCode()
	{
		$errorSummaryCss=CHtml::$errorSummaryCss;

		return <<<EOD
errorLabelContainer: ".{$errorSummaryCss} ul",
errorContainer: ".{$errorSummaryCss}",
wrapper: "li",

showErrors: function(errorMap, errorList) {
	var validation = this;
	$(errorList).each(function() {
		var error = this;
		var qtipapi=$(error.element).qtip('api');
		qtipapi.updateContent(error.message);
		qtipapi.show();
		validation.settings.highlight(error.element);
	})

	for (var i = 0, elements = this.validElements(); elements[i]; i++) {
		validation.settings.unhighlight(elements[i], validation.settings.errorClass, validation.settings.validClass);
	}
},
highlight: function(element) {
	$(element).addClass("error");
},
unhighlight: function(element) {
	$(element).removeClass("error");
	$(element).qtip('hide');
},

EOD;
	}

	/**
	 * Returns a JSON string of the qtip options
	 * @return string
	 */
	public function getOptions()
	{
		return $this->jsOptions===array()?'{}' : CJavaScript::encode(
			CMap::mergeArray($this->jsOptions, array(
				'content' => array(
					'text' => '',
					'prerender' => true,
				),
			)),
			true);
	}
}
?>
