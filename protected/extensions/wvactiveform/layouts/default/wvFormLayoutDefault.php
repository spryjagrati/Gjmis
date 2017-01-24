<?php
class wvFormLayoutDefault extends wvFormLayout
{
	/**
	 * Adds jquery.Validation options
	 */
	public function init()
	{
		$this->form->rulesParams['wvFormjQueryValidateRule']=array(
			'optionsCode'=>$this->getjQueryValidationOptionsCode(),
		);
		parent::init();
	}

	/**
	 * Always adds the error field, even if no errors, so we can manipulate it with
	 * jQuery.validate.
	 */
	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true)
	{
		if(!$this->form->enableAjaxValidation || !$enableAjaxValidation)
		{
			//$error=$model->getError($attribute);
			$error=''; // do not show field errors, only summary
			$for=CHtml::getIdByName(CHtml::resolveName($model,$attribute));
			$htmlOptions['class']=CHtml::$errorMessageCss;
			return CHtml::label($error,$for,$htmlOptions);
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
			$content='';
			if(!is_array($model))
				$model=array($model);
			if(isset($htmlOptions['firstError']))
			{
				$firstError=$htmlOptions['firstError'];
				unset($htmlOptions['firstError']);
			}
			else
				$firstError=false;
			foreach($model as $m)
			{
				foreach($m->getErrors() as $attribute => $errors)
				{
					foreach($errors as $error)
					{
						if($error!='')
							$content.="<li>".CHtml::activeLabel($m, $attribute,array('label'=>$error, 'style'=>'display: block;'))."</li>\n";
						if($firstError)
							break;
					}
				}
			}

			if($header===null)
				$header='<p>'.Yii::t('yii','Please fix the following input errors:').'</p>';
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=CHtml::$errorSummaryCss;
			if($content=='')
				$htmlOptions['style']='display: none;';
			return CHtml::tag('div',$htmlOptions,$header."\n<ul>\n$content</ul>".$footer);
		}
		return false;
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

EOD;
	}
}
?>
