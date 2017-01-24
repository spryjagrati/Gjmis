<?php
class BossForm extends CFormModel
{
    public $skucode;






	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// skuid and idclient are required
			array('skucode', 'required'),

		);
	}

        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'skucode' => 'SKU Names',
		);
	}





}


?>
