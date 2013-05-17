<?php
App::uses('Security', 'Utility');

class User extends AppModel {
	
	public $name = 'User';
	
	 public $validate = array(
	 
	 	'username' =>  array(
	        'rule'    => 'notEmpty',
	        'message' => 'This field cannot be left blank'
        ),
        
        'password' => array(
	        'rule'    => 'notEmpty',
	        'message' => 'This field cannot be left blank'
        )
     );
     
      public function beforeSave($options = array()) {
        // Use bcrypt
        if (isset($this->data['User']['password'])) {
            $hash = Security::hash($this->data['User']['password'], 'blowfish');
            $this->data['User']['password'] = $hash;
        }
        return true;
    }			
}