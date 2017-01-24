wvActiveForm 0.7
=======================================
http://code.google.com/p/wvactiveform/

wvActiveForm is a CActiveForm descendant that validates the input on client
with jQuery, using the rules defined at the model, while also supporting custom
rules. Besides validation some rules may also filter invalid characters
during typing.

Validators:

- Required
- Number
- String (length)
- Email
- Default value (displays value that disappear on field click)
- No whitespace
- URL
- Manual rules


Rules:

- jQuery.Validate
- jQuery.Numeric
- jQuery.DefaulValue
- jQuery.keyFilter


CValidator supported:

- CRequiredValidator
- CStringValidator
- CNumberValidator
- CEmailValidator
- CUrlValidator


Usage
=====
Just replace the CActiveForm class with wvActiveForm, and you should automatically
get client validation if you use validators on your model.

For example:

<?php $form = $this->beginWidget('ext.wvactiveform.wvActiveForm', array('id'=>'form')); ?>
...
<?php $this->endWidget(); ?>

Layout support
==============
Starting with 0.7, now wvActiveForm supports layouts for error messages. Just add a
'layoutName' paramater to the form. There are 2 built-in layouts, 'default' 
(which is compatible with the default Yii error messages) and 'qtip', based on
jQuery.qtip.

NOTE: because of this support, the wvActiveFormDefaultLayout class is deprecated.
Use the 'default' layout instead.

<?php $form = $this->beginWidget('ext.wvactiveform.wvActiveForm',
	array('id'=>'form', 'layoutName'=>'default')); ?>
...


<?php $form = $this->beginWidget('ext.wvactiveform.wvActiveForm',
	array('id'=>'form', 'layoutName'=>'qtip', 
		'layoutParams'=>array('mergeJsOptions'=>array(
			'style'=>array(
				'border'=>array(
					'color' => '#E0B012'
				)
			)
		))
	)); ?>
...


Author
======
Rangel Reale (rangelreale@gmail.com)