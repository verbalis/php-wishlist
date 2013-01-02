<?php

/**
 * This is the model class for table "wl_users".
 *
 * The followings are the available columns in table 'wl_users':
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $email
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, password, email', 'required'),
				array('name', 'length', 'max'=>64),
				array('password', 'length', 'max'=>256),
				array('email', 'length', 'max'=>128),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, name, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'name' => 'Name',
				'password' => 'Password',
				'email' => 'Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * Customize the insert to build the password properly
	 * @see CActiveRecord::insert()
	 */
	public function insert($attributes=null)
	{
		if($this->getIsNewRecord()){
			echo 'Password= "' . $this->password . '"';
			Yii::log('Password= "' . $this->password . '"');
			$salt = self::generateSalt($this->name);
			echo 'Salt= "' . $salt . '"';
			Yii::log('Salt= "' . $salt . '"');
			$this->password = self::hashPassword($this->password, $salt);
		}
		return parent::insert($attributes);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		Yii::log('Validating password for User: "' . $this->email . '"');
		$dbHash = $this->password;
		// The first 64 characters of the hash is the salt
		$salt = substr($dbHash, 0, 64);

		$hash = self::hashPassword($password, $salt);

		return $hash == $dbHash;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @param string salt
	 * @return string hash
	 */
	public function hashPassword($password,$salt)
	{
		// Prefix the password with the salt
		$hash = $salt . $password;

		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
			$hash = hash('sha256', $hash);
		}

		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;

		return $hash;
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	protected function generateSalt($username)
	{
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'greedy much?' and the username
		// to the salt as well for added security

		$salt = hash('sha256', uniqid(mt_rand(), true) . 'greedy much?' . strtolower($username));
		return $salt;
	}
}