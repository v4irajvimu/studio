<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $slogon
 * @property string $email
 * @property string $tp_1
 * @property string $tp_2
 * @property string $fax
 * @property string $clr_header_bg
 * @property string $clr_header_txt
 * @property string $clr_subheader_bg
 * @property string $clr_subheader_txt
 * @property string $clr_body_bg
 * @property string $clr_body_txt
 * @property string $clr_popup_border
 * @property string $clr_popup_bg
 * @property string $clr_popup_txt
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address', 'length', 'max'=>255),
			array('slogon', 'length', 'max'=>150),
			array('email', 'length', 'max'=>100),
			array('tp_1, tp_2, fax', 'length', 'max'=>45),
			array('clr_header_bg, clr_header_txt, clr_subheader_bg, clr_subheader_txt, clr_body_bg, clr_body_txt, clr_popup_border, clr_popup_bg, clr_popup_txt', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, slogon, email, tp_1, tp_2, fax, clr_header_bg, clr_header_txt, clr_subheader_bg, clr_subheader_txt, clr_body_bg, clr_body_txt, clr_popup_border, clr_popup_bg, clr_popup_txt', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'Users', 'company_id'),
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
			'address' => 'Address',
			'slogon' => 'Slogon',
			'email' => 'Email',
			'tp_1' => 'Tp 1',
			'tp_2' => 'Tp 2',
			'fax' => 'Fax',
			'clr_header_bg' => 'Clr Header Bg',
			'clr_header_txt' => 'Clr Header Txt',
			'clr_subheader_bg' => 'Clr Subheader Bg',
			'clr_subheader_txt' => 'Clr Subheader Txt',
			'clr_body_bg' => 'Clr Body Bg',
			'clr_body_txt' => 'Clr Body Txt',
			'clr_popup_border' => 'Clr Popup Border',
			'clr_popup_bg' => 'Clr Popup Bg',
			'clr_popup_txt' => 'Clr Popup Txt',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('slogon',$this->slogon,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tp_1',$this->tp_1,true);
		$criteria->compare('tp_2',$this->tp_2,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('clr_header_bg',$this->clr_header_bg,true);
		$criteria->compare('clr_header_txt',$this->clr_header_txt,true);
		$criteria->compare('clr_subheader_bg',$this->clr_subheader_bg,true);
		$criteria->compare('clr_subheader_txt',$this->clr_subheader_txt,true);
		$criteria->compare('clr_body_bg',$this->clr_body_bg,true);
		$criteria->compare('clr_body_txt',$this->clr_body_txt,true);
		$criteria->compare('clr_popup_border',$this->clr_popup_border,true);
		$criteria->compare('clr_popup_bg',$this->clr_popup_bg,true);
		$criteria->compare('clr_popup_txt',$this->clr_popup_txt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
