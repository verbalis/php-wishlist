<?php

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

	// Store model to not repeat query.
	private $_model;

	// Return first name.
	// access it by Yii::app()->user->first_name
	function getName(){
		$user = $this->loadUser(Yii::app()->user->id);
		return $user->name;
	}

	// This is a function that checks the field 'role'
	// in the User model to be equal to 1, that means it's admin
	// access it by Yii::app()->user->isAdmin()
	function isAdmin(){
		$user = $this->loadUser(Yii::app()->user->id);
		return intval($user->role) == 0;
	}

	// Load user model.
	protected function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null)
				$this->_model=User::model()->find('email=:emailAddr', array(':emailAddr'=>$id));
// 				$this->_model=User::model()->findByPk($id);
		}
		return $this->_model;
	}
}
?>