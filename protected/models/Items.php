<?php

/**
 * This is the model class for table "items".
 *
 * The followings are the available columns in table 'items':
 * @property integer $id
 * @property string $name
 * @property string $cost
 * @property string $selling
 * @property string $min_price
 * @property string $max_price
 * @property integer $online
 * @property integer $reorder_level
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 * @property Stock[] $stocks
 * @property WrkOrderHasItems[] $wrkOrderHasItems
 */
class Items extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id', 'required'),
			array('online, reorder_level, supplier_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('cost, selling, min_price, max_price', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, cost, selling, min_price, max_price, online, reorder_level, supplier_id', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'stocks' => array(self::HAS_MANY, 'Stock', 'items_id'),
			'wrkOrderHasItems' => array(self::HAS_MANY, 'WrkOrderHasItems', 'items_id'),
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
			'online' => 'Online',
			'reorder_level' => 'Reorder Level',
			'supplier_id' => 'Supplier',
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
		$criteria->compare('online',$this->online);
		$criteria->compare('reorder_level',$this->reorder_level);
		$criteria->compare('supplier_id',$this->supplier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Items the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
