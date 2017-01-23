<?php

/**
 * This is the model class for table "payments".
 *
 * The followings are the available columns in table 'payments':
 * @property integer $id
 * @property string $name
 * @property integer $online
 * @property string $remark
 * @property string $amount
 * @property string $created
 * @property integer $payment_type_id
 * @property integer $wrk_order_id
 *
 * The followings are the available model relations:
 * @property PaymentType $paymentType
 * @property WrkOrder $wrkOrder
 */
class Payments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type_id, wrk_order_id', 'required'),
			array('online, payment_type_id, wrk_order_id', 'numerical', 'integerOnly'=>true),
			array('name, remark', 'length', 'max'=>45),
			array('amount', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, online, remark, amount, created, payment_type_id, wrk_order_id', 'safe', 'on'=>'search'),
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
			'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
			'wrkOrder' => array(self::BELONGS_TO, 'WrkOrder', 'wrk_order_id'),
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
			'online' => 'Online',
			'remark' => 'Remark',
			'amount' => 'Amount',
			'created' => 'Created',
			'payment_type_id' => 'Payment Type',
			'wrk_order_id' => 'Wrk Order',
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
		$criteria->compare('online',$this->online);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('payment_type_id',$this->payment_type_id);
		$criteria->compare('wrk_order_id',$this->wrk_order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
