<?php

/**
 * This is the model class for table "package_has_pkg_features".
 *
 * The followings are the available columns in table 'package_has_pkg_features':
 * @property integer $id
 * @property string $cost
 * @property string $selling
 * @property string $created
 * @property integer $pkg_features_id
 * @property integer $package_id
 *
 * The followings are the available model relations:
 * @property Package $package
 * @property PkgFeatures $pkgFeatures
 */
class PackageHasPkgFeatures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'package_has_pkg_features';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pkg_features_id, package_id', 'required'),
			array('pkg_features_id, package_id', 'numerical', 'integerOnly'=>true),
			array('cost, selling', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cost, selling, created, pkg_features_id, package_id', 'safe', 'on'=>'search'),
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
			'package' => array(self::BELONGS_TO, 'Package', 'package_id'),
			'pkgFeatures' => array(self::BELONGS_TO, 'PkgFeatures', 'pkg_features_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cost' => 'Cost',
			'selling' => 'Selling',
			'created' => 'Created',
			'pkg_features_id' => 'Pkg Features',
			'package_id' => 'Package',
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
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('selling',$this->selling,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('pkg_features_id',$this->pkg_features_id);
		$criteria->compare('package_id',$this->package_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PackageHasPkgFeatures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
