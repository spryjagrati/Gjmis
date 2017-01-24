<?php
class WorksheetiForm extends CFormModel
{
    public $skuid;
    public $idclient;





	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// skuid and idclient are required
			array('skuid, idclient', 'required'),

		);
	}

        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'skuid' => 'SKU IDs',
			'idclient' => 'Venue',
		);
	}





}


?>
