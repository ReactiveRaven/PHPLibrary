<?php

class RRaven_Array_Toolbox {
	
	/**
	 * Returns true if you can pass the variable to a foreach loop, or similar.
	 *
	 * @param mixed $array
	 * @return boolean
	 */
	public static function isIterable($array) {
		return 
			is_array($array) 
			|| $array instanceof Iterator;
	}
	
	/**
	 * Returns true if the variable can be `count()`ed.
	 *
	 * @param mixed $array
	 * @return boolean
	 */
	public static function isCountable($array) {
		return 
			is_array($array)
			|| $array instanceof Countable;
	}
	
	/**
	 * Returns true if you can access keys within the variable like an array.
	 * 
	 * eg: $array["keyname"]
	 *
	 * @param mixed $array
	 * @return boolean
	 */
	public static function isArrayAccessible($array) {
		return 
			is_array($array) 
			|| $array instanceof ArrayAccess;
	}
		
	/**
	 * Removes duplicate values from an array.
	 * Does not act recursively, only compares values directly.
	 * 
	 * @param type $array
	 * @return type
	 * @throws Exception 
	 */
	public static function remove_duplicates($array) {
		if (!self::isIterable($array)) {
			throw new Exception("Can't loop over the variable given");
		}
		
		$result = array();
		foreach ($array as $key => $val) {
			if (!in_array($val, $result)) {
				$result[$key] = $val;
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns true if a variable is array-like.
	 * Objects such as ArrayObjects will not be considered 'arrays' by the 
	 * PHP builtin function `is_array()`. `isArrayLike()` will return true for 
	 * both arrays and objects that can be treated as arrays.
	 *
	 * @param mixed $array
	 * @return boolean
	 */
	public static function isArrayLike($array) {
		return 
			is_array($array)
			|| $array instanceof ArrayObject
			|| (
				self::isIterable($array) 
				&& self::isArrayAccessible($array) 
				&& self::isCountable($array)
			);
	}
	
	/**
	 * Combines two arrays into one, using one array for keys and the other for 
	 * values.
	 *
	 * @param array $keys
	 * @param array $values
	 * @return array
	 */
	public static function combine($keys, $values) {
		if (!self::isIterable($keys) || !self::isIterable($values)) {
			throw new Exception("Can't loop over the variables given");
		}
		if (!self::isArrayAccessible($values)) {
			$values = self::extractArrayFromIterable($values);
		}
		$result = array();
		foreach ($keys as $k => $key) {
			$result[$key] = $values[$k];
		}
		return $result;
	}
	
	/**
	 * Converts an iterable to a real array object.
	 *
	 * @param mixed $array
	 * @return array
	 */
	private static function extractArrayFromIterable($array) {
		if (!self::isIterable($array)) {
			throw new Exception("Can't loop over the variable given");
		}
		$return = array();
		foreach ($array as $k => $v) {
			$return[$k] = $v;
		}
		return $return;
	}
	
	/**
	 * Pulls keys out from a sub-array in a multidimensional array.
	 * If an array of keys is passed in, will drill down repeatedly using 
	 * the first key at the root of the array, drilling down towards the leaves.
	 * Note that parent keys are not preserved in the output array, but the 
	 * values are inserted in the same order, so array_combine may be of use.
	 * 
	 * example usage:
	 * collect(
	 *   array(
	 *     "alice" => array(
	 *       "pet" => array(
	 *         "name" => "MrWhiskers",
	 *         "type" => "cat"
	 *       )
	 *     ),
	 *     "ben" => array(
	 *       "pet" => array(
	 *         "name" => "Blub",
	 *         "type" => "goldfish"
	 *       )
	 *     ),
	 *     "chris" => array(
	 *       "pet" => array(
	 *         "type" => "none"
	 *       )
	 *     )
	 *   ), 
	 *   array(
	 *     "pet", 
	 *     "name"
	 *   )
	 * );
	 * 
	 * example output:
	 * array(
	 *   "MrWhiskers",
	 *   "Blub",
	 *   NULL
	 * )
	 *
	 * @param array $array
	 * @param string|array $key
	 * 
	 * @return array
	 */
	public static function collect($array, $key) {
		$myKey = $key;
		if (self::isCountable($key) && count($key)) {
			$myKey = array_shift($key);
		}
		
		$results = array();
		foreach ($array as $index => $value) {
			if (self::isArrayAccessible($value) && isset($value[$myKey])) {
				$results[] = $value[$myKey];
			} else {
				$results[] = null;
			}
		}
		
		if (self::isCountable($key) && count($key)) {
			return self::collect($results, $key);
		}
		
		return $results;
	}
	
	/**
	 * Rotates a multidimensional array.
	 * Rotates so $a[row][col] becomes $a[col][row].
	 *
	 * @param array $array
	 * @return array
	 */
	public static function rotateArray($array) {
		if (!self::isIterable($array)) {
			throw new Exception("Can't loop over the variables given");
		}
		$result = array();
		foreach ($array as $x => $row) {
			if (!self::isIterable($row)) {
				throw new Exception("Can't loop over a row inside the array");
			}
			foreach ($row as $y => $val) {
				if (!isset($result[$y])) {
					$result[$y] = array();
				}
				$result[$y][$x] = $val;
			}
		}
		return $result;
	}
	
	/**
	 * Returns values in either left or right, but not both.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array 
	 */
	public static function xor_values($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		return 
			self::and_not_values(
				self::or_values($left, $right), // Ab, aB, AB.
				self::and_values($left, $right) // AB
			);
	}
	
	/**
	 * Returns keys in either left or right, but not both.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function xor_keys($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		return 
			self::and_not_keys(
				self::or_keys($left, $right), // Ab, aB, AB.
				self::and_keys($left, $right)  // AB
			);
	}
	
	/**
	 * Returns keys in left, but not right.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function and_not_keys($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		$known = array();
		foreach ($right as $key => $val) {
			$known[] = $key;
			$val = $val;
		}
		$result = array();
		foreach ($left as $key => $val) {
			if (!in_array($key, $known)) {
				$result[$key] = $val;
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns values in left, but not right
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function and_not_values($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		$known = array();
		foreach ($right as $val) {
			$known[] = $val;
		}
		$result = array();
		foreach ($left as $key => $val) {
			if (!in_array($val, $known)) {
				$result[$key] = $val;
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns values that occur in both left *and* right.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function and_values($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		$known = array();
		foreach ($right as $val) {
			$known[] = $val;
		}
		$result = array();
		foreach ($left as $key => $val) {
			if (in_array($val, $known)) {
				$result[$key] = $val;
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns keys that occur in both left *and* right.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function and_keys($left, $right) {
		if (!self::isIterable($left) || !self::isIterable($right)) {
			throw new Exception("Can't loop over the variables given");
		}
		$known = array();
		foreach ($right as $key => $val) {
			$known[] = $key;
		}
		$result = array();
		foreach ($left as $key => $val) {
			if (in_array($key, $known)) {
				$result[$key] = $val;
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns keys in either left or right, using the value from left when a 
	 * key occurs in both.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function or_keys($left, $right) {
		$result = array();
		foreach ($left as $key => $val) {
			$result[$key] = $val;
		}
		foreach ($right as $key => $val) {
			if (!isset($result[$key])) {
				$result[$key] = $val;
			}
		}
		return $result;
	}
	
	/**
	 * Returns values in either left or right, using the key from left when a 
	 * value occurs in both.
	 * When a key is in both, but has different values, the value is appended to
	 * the end of the array with a numeric index.
	 *
	 * @param array $left
	 * @param array $right
	 * @return array
	 */
	public static function or_values($left, $right) {
		$result = array();
		foreach ($left as $key => $val) {
			if (!in_array($val, $result)) {
				$result[$key] = $val;
			}
		}
		foreach ($right as $key => $val) {
			if (!in_array($val, $result)) {
				if (!isset($result[$key])) {
					$result[$key] = $val;
				} else {
					$result[] = $val;
				}
			}
		}
		return $result;
	}
	
}