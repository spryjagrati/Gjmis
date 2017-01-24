<?php
class RsiForm extends CFormModel
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
			//array('skuid','numerical','integerOnly'=>true ,'message'=>'Special character not allowed'),

		);
	}
        /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'skuid' => 'SKU ID',
			'idclient' => 'Venue',
		);
	}
}
?>
