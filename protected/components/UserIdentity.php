<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	private $_model;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if(!isset($this->username)){
			Yii::log('Username not set');
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		Yii::log('Logging in with username: "' . $this->username . '"');
		$user=loadUser($this->username);
		if(!isset($user)){
			Yii::log('User not in the system');
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		}
		else{
			Yii::log('Password entered: "' . $this->password . '"');
			$validPassword = $user->validatePassword($this->password);
			$this->errorCode = ($validPassword) ? self::ERROR_NONE : self::ERROR_PASSWORD_INVALID;  
		}
		Yii::log('Error code: ' . $this->errorCode);
		return !$this->errorCode;
	}
	
	function isAdmin(){
		$user = $this->loadUser(Yii::app()->user->id);
		return intval($user->role) == 1;
	}
	
	// Load user model.
	protected function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null)
				$this->_model=User::model()->find('email=:emailAddr', array(':emailAddr'=>$this->username));//User::model()->findByPk($id);
		}
		return $this->_model;
	}
	
}