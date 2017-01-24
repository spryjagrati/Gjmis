<?php
/**
 * CascadedValidator runs any other validator, but only after a parent attribute is validated first
 *
 * This validator is useful for forms with multiple branches, ie to validate fields only if other  
 * fields conform to certain preconditions.
 *
 * Usage example:
 * $rules = array(
 *   array('userEmail', 'CascadedValidator', 'parentRule' => array('receiveNewsletter', 'match', 'pattern' => '/yes, please/'), 'childRule' => array('email')),
 * )
 *
 * @author Jonas Girnatis <jonas@girnatis.de>
 * @version $Id: CCompareValidator.php 1678 2010-01-07 21:02:00Z qiang.xue $
 * @since 1.0
 */
class CascadedValidator extends CValidator
{
	/**
	 * @var array the rule the parent attribute must match before the child rule will be evaluated
	 * Use the normal rule syntax.
	 * array('attributeName', 'validatorClass', ['param1' => 'value1', 'param2' => 'value2', ...])
	 */
	public $parentRule;

	/**
	 * @var array the rule the child attribute is validated by.
	 * This rule is enforced only if the parent rule matches. 
	 * Use the normal rule syntax, except no need to pass in the attribute name as first item (uses
	 * the attribute the CascadedValidator is attached to):
	 * array('validatorClass', ['param1' => 'value1', 'param2' => 'value2', ...])
	 */
	public $childRule;

	/**
	 * @var boolean switches if the child rule is checked if the parent rule does or does not match.
	 * Defaults to false, meaning the child rule will be evaluated only if the parent rule matches.
	 */
	public $negateParentCheck = false;

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$parentRule = $this->parentRule;
		$parentAttribute = $parentRule[0];
		$parentValue = $object->$parentRule[0];
		$parentValidatorClass = $parentRule[1];
		
		//hack so that checks for parent validity dont add to form errors
		$parentClass = get_class($object);
		$parentObject = new $parentClass;
		$parentObject->{$parentAttribute} = $parentValue;

		$parentValidator = CValidator::createValidator($parentValidatorClass,$parentObject,$parentAttribute,array_slice($parentRule,2));
		$parentValidator->validate($parentObject, $parentValue);
		
		if($parentObject->hasErrors() == $this->negateParentCheck)
		{
			$childRule = $this->childRule;
			$childValue = $object->$attribute;

			$childValidator = CValidator::createValidator($childRule[0], $object, $attribute, array_slice($childRule,1));
			$childValidator->validate($object, $childValue);
		}
	}
}