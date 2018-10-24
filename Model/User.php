<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Listing $Listing
 */
class User extends AppModel {


	public function beforeSave($options = array()) {
		if(!$this->id){
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['encrypted_password'] = $passwordHasher->hash(
				$this->data[$this->alias]['encrypted_password']
			);
		}
		return true ;
	}
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Listing' => array(
			'className' => 'Listing',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	

}
