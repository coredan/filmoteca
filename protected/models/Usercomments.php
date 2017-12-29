<?php

/**
 * This is the model class for table "{{usercomments}}".
 *
 * The followings are the available columns in table '{{usercomments}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $film_id
 * @property string $content
 * @property integer $rating
 * @property string $enter_date
 * @property integer $moderated
 *
 * The followings are the available model relations:
 * @property Films $film
 * @property Users $user
 */
class Usercomments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{usercomments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, film_id, content', 'required'),
			array('user_id, film_id, rating, moderated', 'numerical', 'integerOnly'=>true),
			array('enter_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, film_id, content, rating, enter_date, moderated', 'safe', 'on'=>'search'),
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
			'film' => array(self::BELONGS_TO, 'Films', 'film_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'film_id' => 'Film',
			'content' => 'Content',
			'rating' => 'Rating',
			'enter_date' => 'Enter Date',
			'moderated' => 'Moderated',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('film_id',$this->film_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('enter_date',$this->enter_date,true);
		$criteria->compare('moderated',$this->moderated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usercomments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
