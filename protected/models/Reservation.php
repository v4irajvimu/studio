<?php

/**
 * This is the model class for table "reservation".
 *
 * The followings are the available columns in table 'reservation':
 * @property integer $id
 * @property string $code
 * @property integer $package_id
 * @property string $eff_date
 * @property integer $is_custom
 * @property string $total
 * @property integer $customer_id
 * @property integer $is_accepted
 *
 * The followings are the available model relations:
 * @property Customer $customer
 * @property ReservationHasPkgFeatures[] $reservationHasPkgFeatures
 */
class Reservation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reservation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'required'),
			array('package_id, is_custom, customer_id, is_accepted', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>30),
			array('total', 'length', 'max'=>10),
			array('eff_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, package_id, eff_date, is_custom, total, customer_id, is_accepted', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'reservationHasPkgFeatures' => array(self::HAS_MANY, 'ReservationHasPkgFeatures', 'reservation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'package_id' => 'Package',
			'eff_date' => 'Eff Date',
			'is_custom' => 'Is Custom',
			'total' => 'Total',
			'customer_id' => 'Customer',
			'is_accepted' => 'Is Accepted',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('eff_date',$this->eff_date,true);
		$criteria->compare('is_custom',$this->is_custom);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('is_accepted',$this->is_accepted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reservation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
