<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
 * @property integer $id
 * @property integer $trans_type_id
 * @property integer $items_id
 * @property integer $supplier_id
 * @property integer $qty_in
 * @property integer $qty_out
 * @property string $eff_date
 * @property string $cost
 * @property string $selling
 * @property string $amount
 * @property string $remark
 * @property string $wo_type
 * @property integer $online
 * @property string $created
 * @property integer $wrk_order_id
 *
 * The followings are the available model relations:
 * @property Items $items
 * @property Supplier $supplier
 * @property TransType $transType
 * @property WrkOrder $wrkOrder
 */
class Stock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trans_type_id, items_id, supplier_id, wrk_order_id', 'required'),
			array('trans_type_id, items_id, supplier_id, qty_in, qty_out, online, wrk_order_id', 'numerical', 'integerOnly'=>true),
			array('cost, selling, amount', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>100),
			array('wo_type', 'length', 'max'=>6),
			array('eff_date, created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, trans_type_id, items_id, supplier_id, qty_in, qty_out, eff_date, cost, selling, amount, remark, wo_type, online, created, wrk_order_id', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'transType' => array(self::BELONGS_TO, 'TransType', 'trans_type_id'),
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
			'trans_type_id' => 'Trans Type',
			'items_id' => 'Items',
			'supplier_id' => 'Supplier',
			'qty_in' => 'Qty In',
			'qty_out' => 'Qty Out',
			'eff_date' => 'Eff Date',
			'cost' => 'Cost',
			'selling' => 'Selling',
			'amount' => 'Amount',
			'remark' => 'Remark',
			'wo_type' => 'Wo Type',
			'online' => 'Online',
			'created' => 'Created',
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
		$criteria->compare('trans_type_id',$this->trans_type_id);
		$criteria->compare('items_id',$this->items_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('qty_in',$this->qty_in);
		$criteria->compare('qty_out',$this->qty_out);
		$criteria->compare('eff_date',$this->eff_date,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('selling',$this->selling,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('wo_type',$this->wo_type,true);
		$criteria->compare('online',$this->online);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('wrk_order_id',$this->wrk_order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
