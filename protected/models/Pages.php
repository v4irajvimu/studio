<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $thumb
 * @property integer $page_number
 * @property integer $epaper_id
 * @property integer $eff_month
 * @property integer $eff_year
 * @property integer $publication_number
 *
 * The followings are the available model relations:
 * @property Epaper $epaper
 */
class Pages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('epaper_id', 'required'),
			array('page_number, epaper_id, eff_month, eff_year, publication_number', 'numerical', 'integerOnly'=>true),
			array('thumb', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, thumb, page_number, epaper_id, eff_month, eff_year, publication_number', 'safe', 'on'=>'search'),
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
			'epaper' => array(self::BELONGS_TO, 'Epaper', 'epaper_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'thumb' => 'Thumb',
			'page_number' => 'Page Number',
			'epaper_id' => 'Epaper',
			'eff_month' => 'Eff Month',
			'eff_year' => 'Eff Year',
			'publication_number' => 'Publication Number',
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
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('page_number',$this->page_number);
		$criteria->compare('epaper_id',$this->epaper_id);
		$criteria->compare('eff_month',$this->eff_month);
		$criteria->compare('eff_year',$this->eff_year);
		$criteria->compare('publication_number',$this->publication_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
