<?php
class QjciForm extends CFormModel
{
    public $skuid;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// skuid and idclient are required
			array('skuid', 'required'),

		);
	}

        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'skuid' => 'SKU IDs',
		);
	}





}


?>
