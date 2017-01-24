<?php
class wvFormLayout extends CComponent
{
	/**
	 * @var array list of built-in layouts (name=>class)
	 */
	public static $builtInLayouts=array(
		'default'=>'wvFormLayoutDefault',
		'qtip'=>'wvFormLayoutQtip',
	);


	/**
	 * @var wvActiveForm the owner form
	 */
	protected $form;

	/**
	 * Constructor.
	 * 
	 * @param wvActiveForm the form
	 */
	public function __construct($form)
	{
		$this->form = $form;
	}

	/**
	 * Initializes the layout.
	 */
	public function init()
	{
		
	}

	/**
	 * Process the form error method, or return false to do the normal processing.
	 */
	public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true)
	{
		return false;
	}

	/**
	 * Process the form errorSummary method, or return false to do the normal processing.
	 */
	public function errorSummary($model,$header=null,$footer=null,$htmlOptions=array())
	{
		return false;
	}

	/**
	 * Called before the run() method is executed.
	 */
	public function beforeRun()
	{
		return;
	}

	/**
	 * Called after the run() method is executed.
	 */
	public function afterRun()
	{
		return;
	}

	/**
	 * Creates the layout object.
	 *
	 * @param wvActiveForm the owner form
	 * @param string layout class name or alias
	 * @param mixed layout parameters
	 * @return wvFormLayout the layout object
	 */
	public static function createLayout($form, $name, $params = array())
	{
		if (isset(self::$builtInLayouts[$name]))
		{
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'layouts'.
				DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.self::$builtInLayouts[$name].'.php');
			$name = self::$builtInLayouts[$name];
		}

		return Yii::createComponent(CMap::mergeArray(
			array('class'=>$name), $params),
			$form);
	}
}
?>
