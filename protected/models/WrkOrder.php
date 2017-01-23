<?php

/**
 * This is the model class for table "wrk_order".
 *
 * The followings are the available columns in table 'wrk_order':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $eff_date
 * @property string $wo_type
 * @property string $delivery_date
 * @property string $remark
 * @property integer $wo_status_id
 * @property integer $customer_id
 *
 * The followings are the available model relations:
 * @property Payments[] $payments
 * @property Stock[] $stocks
 * @property Customer $customer
 * @property WoStatus $woStatus
 * @property WrkOrderHasItems[] $wrkOrderHasItems
 */
class WrkOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wrk_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wo_status_id, customer_id', 'required'),
			array('wo_status_id, customer_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('code', 'length', 'max'=>15),
			array('wo_type', 'length', 'max'=>6),
			array('remark', 'length', 'max'=>255),
			array('eff_date, delivery_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code, eff_date, wo_type, delivery_date, remark, wo_status_id, customer_id', 'safe', 'on'=>'search'),
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
			'payments' => array(self::HAS_MANY, 'Payments', 'wrk_order_id'),
			'stocks' => array(self::HAS_MANY, 'Stock', 'wrk_order_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'woStatus' => array(self::BELONGS_TO, 'WoStatus', 'wo_status_id'),
			'wrkOrderHasItems' => array(self::HAS_MANY, 'WrkOrderHasItems', 'wrk_order_id'),
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
			'code' => 'Code',
			'eff_date' => 'Eff Date',
			'wo_type' => 'Wo Type',
			'delivery_date' => 'Delivery Date',
			'remark' => 'Remark',
			'wo_status_id' => 'Wo Status',
			'customer_id' => 'Customer',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('eff_date',$this->eff_date,true);
		$criteria->compare('wo_type',$this->wo_type,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('wo_status_id',$this->wo_status_id);
		$criteria->compare('customer_id',$this->customer_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WrkOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
