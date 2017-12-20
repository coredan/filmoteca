<?php

/**
 * This is the model class for table "{{films}}".
 *
 * The followings are the available columns in table '{{films}}':
 * @property integer $id
 * @property string $title
 * @property string $title_es
 * @property integer $year
 * @property string $director
 * @property string $casting
 * @property string $country
 * @property string $synopsis
 * @property string $image
 * @property double $nota
 * @property integer $imdb_code
 * @property string $trailer
 * @property string $ins_date
 *
 * The followings are the available model relations:
 * @property FilmsGenres[] $filmsGenres
 * @property Torrents[] $torrents
 */
class Films extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{films}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, image', 'required'),
			array('year, imdb_code', 'numerical', 'integerOnly'=>true),
			array('nota', 'numerical'),
			array('title, title_es, director, country, image, trailer', 'length', 'max'=>255),
			array('casting, synopsis, ins_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, title_es, year, director, casting, country, synopsis, image, nota, imdb_code, trailer, ins_date', 'safe', 'on'=>'search'),
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
			'torrents' => array(self::HAS_MANY, 'Torrents', 'film_id'),
			'links' => array(self::HAS_MANY, 'Links', 'film_id'),

			'filmsGenres' => array(self::HAS_MANY, 'FilmsGenres', 'film_id'),
            'genres' => array(self::HAS_MANY, 'GenresBase', 'genre_id', 'through' => 'filmsGenres'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'title_es' => 'Title Es',
			'year' => 'Year',
			'director' => 'Director',
			'casting' => 'Casting',
			'country' => 'Country',
			'synopsis' => 'Synopsis',
			'image' => 'Image',
			'nota' => 'Nota',
			'imdb_code' => 'Imdb Code',
			'trailer' => 'Trailer',
			'ins_date' => 'Ins Date',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_es',$this->title_es,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('director',$this->director,true);
		$criteria->compare('casting',$this->casting,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('synopsis',$this->synopsis,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('nota',$this->nota);
		$criteria->compare('imdb_code',$this->imdb_code);
		$criteria->compare('trailer',$this->trailer,true);
		$criteria->compare('ins_date',$this->ins_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Films the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
