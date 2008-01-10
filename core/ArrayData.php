<?php

/**
 * @package sapphire
 * @subpackage view
 */

/**
 * Lets you wrap a bunch of array data into a ViewableData object.
 * This is useful when you want to pass data to a template in the "SilverStripe 1" way of giving a 
 * big data array.
 *
 * Usage:
 * new ArrayData(array(
 *    "ClassName" => "Page",
 *    "AddAction" => "Add a new Page page",
 * ));
 * @package sapphire
 * @subpackage view
 */
class ArrayData extends ViewableData {

	protected $array;
	
	/**
	 * @param object|array $array Either an object with simple properties or an associative array
	 */
	public function __construct($array) {
		if(is_object($array)) {
			$this->array = self::object_to_array($array);
		} elseif(is_array($array) && ArrayLib::is_associative($array)) {
			$this->array = $array;
		} else {
			$this->array = $array;
			user_error(
				"ArrayData::__construct: Parameter needs to be an object or associative array", 
				E_USER_WARNING
			);
		}
	}
	
	public function getField($f) {
		if(is_array($this->array[$f])) {
			return new ArrayData($this->array[$f]);
		} else {
			return $this->array[$f];
		}
	}
	
	public function hasField($f) {
		return isset($this->array[$f]);
	}
	
	/**
	 * Converts an object with simple properties to 
	 * an associative array.
	 * 
	 * TODO Allow for recursive creation of DataObjectSets when property value is an object/array
	 *
	 * @param obj $obj
	 * @return array
	 */
	static function object_to_array($obj) {
		$arr = array();
		foreach($obj as $k=>$v) {
			$arr[$k] = $v;
		}
		
		return $arr;
	}
	
}

?>