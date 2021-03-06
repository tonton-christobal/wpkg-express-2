<?php
/**
 * This file is the model file of the application. Used for
 *  management employees.
 *
 * CakeLdap: Authentication of users by member group of Active Directory.
 * @copyright Copyright 2017-2018, Andrey Klimov.
 * @license https://opensource.org/licenses/mit-license.php MIT License
 * @package app.Model
 */

App::uses('EmployeeDb', 'CakeLdap.Model');

/**
 * The model is used for management employees
 *  (model extended in application).
 *
 * @package app.Model
 */
class Employee extends EmployeeDb {

/**
 * Return information about a employee
 *
 * @param int|string $id ID of record or Distinguished name for retieve information
 * @param array|string $excludeFields List of fields for excluding
 *  from result
 * @param bool $includeExtend Flag of including extended information in result
 *  e.g. information about tree subordinate employees.
 * @param array|string $fieldsList List of fields for retieve information
 * @param array|string $contain List of binded models
 * @return array|bool Return array of informationa about a employee,
 *  or False on failure.
 */
	public function get($id = null, $excludeFields = null, $includeExtend = false, $fieldsList = null, $contain = null) {
		if (empty($id)) {
			return false;
		}

		$result = parent::get($id, $excludeFields, $includeExtend, $fieldsList, $contain);
		if ((!$includeExtend) || empty($result)) {
			return $result;
		}
		/*
		$fields = array($this->alias . '.id');
		$conditions = array($this->alias . '.id' => $id);
		$contain = array(
			'ExtendModel'
		);
		$resultExtend = $this->find('first', compact('fields', 'conditions', 'contain'));
		if (!empty($resultExtend))
			$result += $resultExtend;
		*/
		return $result;
	}

/**
 * Get information about extended fields
 *
 * @return array Return array of information about extended
 *  fields in format:
 *   array(
 *      'ExtendeModel.{n}' => array(
 *              'label' => 'Full label',
 *              'altLabel' => 'Short label',
 *              'priority' => 10,
 *          )
 *  ),
 *  where: modelName - is name of model, or Hash::path
 */
	public function getExtendFieldsInfo() {
		$result = parent::getExtendFieldsInfo();
		$resultExtend = [
		/*
			'ExtendeModel.{n}' => array(
				'label' => __('Extend model'),
				'altLabel' => __('Ext. model'),
				'priority' => 1,
			)
		*/
		];
		$result += $resultExtend;

		return $result;
	}

/**
 * Return fields configuration for helper
 *
 * @return array Return array of information about extended
 *  fields in format:
 *   array(
 *      'modelName' => array(
 *              'type' => 'string',
 *              'truncate' => false,
 *          )
 *  ),
 *  where:
 *   - modelName - is name of model, or Hash::path.
 *   - type - type of data. Can be one of:
 *   integer, biginteger, float, date, time, datetime,
 *   timestamp, boolean, guid, photo, mail, string, text,
 *   binary, employee, manager, subordinate, department or
 *   element.
 *   - truncate - truncate text.
 */
	public function getExtendFieldsConfig() {
		$result = parent::getExtendFieldsConfig();
		$resultExtend = [
			/*
			'ExtendeModel' => array(
				'type' => 'string',
				'truncate' => true,
			)
			*/
		];
		$result += $resultExtend;

		return $result;
	}
}
