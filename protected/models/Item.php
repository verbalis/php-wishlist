<?php

/**
 * This is the model class for table "wl_items".
 *
 * The followings are the available columns in table 'wl_items':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $buyer_notes
 * @property integer $buyer_added
 * @property integer $priority
 * @property integer $wants
 * @property integer $has
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
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
		return 'wl_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, buyer_notes', 'required'),
			array('buyer_added, priority, wants, has', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('desc', 'length', 'max'=>512),
			array('buyer_notes', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, buyer_notes, buyer_added, priority, wants, has', 'safe', 'on'=>'search'),
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
			'desc' => 'Desc',
			'buyer_notes' => 'Buyer Notes',
			'buyer_added' => 'Buyer Added',
			'priority' => 'Priority',
			'wants' => 'Wants',
			'has' => 'Has',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('buyer_notes',$this->buyer_notes,true);
		$criteria->compare('buyer_added',$this->buyer_added);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('wants',$this->wants);
		$criteria->compare('has',$this->has);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}