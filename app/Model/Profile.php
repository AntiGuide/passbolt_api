<?php
/**
 * Profile Model
 *
 * Copyright 2012, Passbolt
 * Passbolt(tm), the simple password management solution
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright          Copyright 2012, Passbolt.com
 * @package            app.Model.profile
 * @since              version 2.12.7
 * @license            http://www.passbolt.com/license
 */
class Profile extends AppModel {

	/**
	 * defines belongsTo relationship
	 * @var array
	 */
	public $belongsTo = array(
		'User'
	);

	public static function getFindFields($case = '', $role = Role::USER) {
		$returnValue = array();
		switch ($case) {
			case 'view':
				$returnValue = array(
					'fields' => array(
						'Role.id',
						'Role.name'
					)
				);
				break;
			case 'User::save':
			case 'User::edit':
				$returnValue = array(
					'fields' => array(
						'user_id',
						'first_name',
						'last_name',
					)
				);
				break;
			default:
				$returnValue = array(
					'fields' => array()
				);
				break;
		}

		return $returnValue;
	}

	/**
	 * Get the validation rules upon context
	 *
	 * @param string context
	 *
	 * @return array validation rules
	 * @throws exception if case is undefined
	 * @access public
	 */
	public static function getValidationRules($case = 'default') {
		$default = array(
			'user_id' => array(
				'uuid' => array(
					'rule' => 'uuid',
					'required' => true,
					'allowEmpty' => false,
					'message'	=> __('UUID must be in correct format')
				),
				'exist' => array(
					'rule' => array('userExists', null),
					'message' => __('The user id provided does not exist')
				),
			),
			'gender' => array(
				'required' => array(
					'allowEmpty' => false,
					'rule' => array('notEmpty'),
					'message' => __('Gender cannot be empty')
				),
				'inList' => array(
					'rule' => array('inList', array('m', 'f')),
					'message' => __('Gender can be only "m" or "f"')
				)
			),
			'date_of_birth' => array(
				'date' => array(
					'rule' => array('date', 'ymd'),
					'message' => 'Enter a valid date of birth in YY-MM-DD format.',
					'allowEmpty' => false
				)
			),
			'title' => array(
				'inList' => array(
					'rule' => array('inList', array('Mr', 'Ms', 'Mrs', 'Dr')),
					'message' => __('A valid title has to be provided'),
					'allowEmpty' => false
				)
			),
			'first_name' => array(
				'rule' => '/^[a-zA-Z]+$/i',
				'required' => true,
				'allowEmpty' => false,
				'message'	=> __('First name must be provided')
			),
			'last_name' => array(
				'alphaNumeric' => array(
					'rule' => '/^[a-zA-Z]+$/i',
					'required' => true,
					'allowEmpty' => false,
					'message'	=> __('Last name must be provided')
				)
			)
			// TODO : timezone, locale
		);
		switch ($case) {
			default:
			case 'default' :
				$rules = $default;
		}

		return $rules;
	}

	/**
	 * Check if a user with same id exists
	 * @param check
	 */
	public function userExists($check) {
		if ($check['user_id'] == null) {
			return false;
		} else {
			$exists = $this->User->find('count', array(
					'conditions' => array('User.id' => $check['user_id']),
					'recursive' => -1
				));
			return $exists > 0;
		}
	}
}