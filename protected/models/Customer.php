<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $tp_mobile
 * @property string $tp_fixed
 * @property string $nic
 * @property string $address
 * @property string $gender
 * @property integer $online
 * @property string $created
 * @property string $updated
 * @property integer $visits
 * @property string $code
 * @property string $password
 *
 * The followings are the available model relations:
 * @property WrkOrder[] $wrkOrders
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('online, visits', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('email', 'length', 'max'=>80),
			array('tp_mobile, tp_fixed, code', 'length', 'max'=>15),
			array('nic', 'length', 'max'=>20),
			array('address', 'length', 'max'=>255),
			array('gender', 'length', 'max'=>6),
			array('password', 'length', 'max'=>200),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, tp_mobile, tp_fixed, nic, address, gender, online, created, updated, visits, code, password', 'safe', 'on'=>'search'),
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
			'wrkOrders' => array(self::HAS_MANY, 'WrkOrder', 'customer_id'),
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
			'email' => 'Email',
			'tp_mobile' => 'Tp Mobile',
			'tp_fixed' => 'Tp Fixed',
			'nic' => 'Nic',
			'address' => 'Address',
			'gender' => 'Gender',
			'online' => 'Online',
			'created' => 'Created',
			'updated' => 'Updated',
			'visits' => 'Visits',
			'code' => 'Code',
			'password' => 'Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tp_mobile',$this->tp_mobile,true);
		$criteria->compare('tp_fixed',$this->tp_fixed,true);
		$criteria->compare('nic',$this->nic,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('online',$this->online);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('visits',$this->visits);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
