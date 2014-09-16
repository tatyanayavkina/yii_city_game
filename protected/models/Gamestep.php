<?php

/**
 * This is the model class for table "tbl_gamestep".
 *
 * The followings are the available columns in table 'tbl_gamestep':
 * @property integer $gameId
 * @property integer $cityId
 * @property integer $stepNumber
 *
 * The followings are the available model relations:
 * @property Game $game
 * @property City $city
 */
class Gamestep extends CActiveRecord
{
    //ошибка пользователя
    public $error=GameUtils::ERROR_SUCCESS;
    //название города
    public $cityName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_gamestep';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gameId, cityId, stepNumber, stepOwner, error, cityName', 'safe'),
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
			'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
			'city' => array(self::BELONGS_TO, 'City', 'cityId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gameId' => 'Game',
			'cityName' => 'Ваш ход',
			'stepNumber' => 'Номер хода',
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

		$criteria->compare('gameId',Yii::app()->session['gameId']);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$this->getLastStepNumber(),
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gamestep the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->gameId = Yii::app()->session['gameId'];
            $this->cityId = City::model()->getCityIdByName($this->cityName);
            Game::model()->setLastStepDate();
            return true;
        }

        return false;
    }


    //города, использованные в игре
    public function citiesUsedInGame()
    {
        $cityNames = array();
        $criteria = new CDbCriteria;
        $criteria->condition = 'gameId = :gameId';
        $criteria->params = array(':gameId'=>Yii::app()->session['gameId']);
        $criteria->with=array('city');
        $gameSteps = self::model()->findAll($criteria);

        foreach( $gameSteps as $step )
        {
            $cityNames[] = $step->city->name;
        }

        return $cityNames;
    }

    //функция возвращает номер последнего хода игры
    public function getLastStepNumber(){
        return self::model()->countByAttributes(array('gameId' => Yii::app()->session['gameId']));
    }

    //функция возвращает последний ход игры
    public function getLastStep($stepNumber){
        $criteria = new CDbCriteria;
        $criteria->condition = 'gameId = :gameId';
        $criteria->addCondition('stepNumber = :stepNumber');
        $criteria->params = array(':gameId'=>Yii::app()->session['gameId'],':stepNumber'=>$stepNumber);
        return self::model()->find($criteria);
    }

    public function saveStep($cityName,$stepNumber)
    {
        $this->cityName= $cityName;
        $this->stepNumber = $stepNumber;
        $this->save();
    }

    public function checkCityAlreadyExist($cityName)
    {
        $cityId = City::model()->getCityIdByName($cityName);
        $criteria = new CDbCriteria;
        $criteria->condition = 'gameId = :gameId';
        $criteria->addCondition('cityId = :cityId');
        $criteria->params = array(':gameId'=>Yii::app()->session['gameId'],':cityId'=>$cityId);
        $step = self::model()->find($criteria);
        if ($step === null)
        {
            return false;
        }
        return true;
    }

    public function getLastLetter()
    {
        $lastStepNumber = self::getLastStepNumber();
        $step =  self::getLastStep($lastStepNumber);
        return $step->city->lastLetter;
    }
}
