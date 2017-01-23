<?php

/**
 * This is the model class for table "wrk_order_has_items".
 *
 * The followings are the available columns in table 'wrk_order_has_items':
 * @property integer $id
 * @property string $name
 * @property string $cost
 * @property string $selling
 * @property string $min_price
 * @property string $max_price
 * @property string $qty
 * @property string $amount
 * @property integer $items_id
 * @property integer $wrk_order_id
 *
 * The followings are the available model relations:
 * @property Items $items
 * @property WrkOrder $wrkOrder
 */
class WrkOrderHasItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wrk_order_has_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('items_id, wrk_order_id', 'required'),
			array('items_id, wrk_order_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('cost, selling, min_price, max_price, qty, amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, cost, selling, min_price, max_price, qty, amount, items_id, wrk_order_id', 'safe', 'on'=>'search'),
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
			'items' => array(self::BELONGS_TO, 'Items', 'items_id'),
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
			'cost' => 'Cost',
			'selling' => 'Selling',
			'min_price' => 'Min Price',
			'max_price' => 'Max Price',
			'qty' => 'Qty',
			'amount' => 'Amount',
			'items_id' => 'Items',
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
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('selling',$this->selling,true);
		$criteria->compare('min_price',$this->min_price,true);
		$criteria->compare('max_price',$this->max_price,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('items_id',$this->items_id);
		$criteria->compare('wrk_order_id',$this->wrk_order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WrkOrderHasItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
