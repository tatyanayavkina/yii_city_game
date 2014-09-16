<?php

class GamestepController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';



	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        //для отображения всех ходов
        $steps = new Gamestep;
		$userStep=new Gamestep;

        if(isset($_POST['Gamestep']))
        {
            $userStep->attributes = $_POST['Gamestep'];
            $cityName = trim(mb_strtolower($userStep->cityName));

            //если город, ведденный пользователем, отсутствует в нашей БД, сохраняем
            //при условии, что в Википедии существует страница, в которой сказано о существовании такого города
            if ($this->ifCityUndefined($userStep,$cityName))
            {
                $this->renderContent($userStep,$steps);
                return;
            }

            $lastStepNumber = Gamestep::model()->getLastStepNumber()+1;
            //проверяем ход пользователя
            if(!$this->checkAndSaveUserStep($userStep,$cityName,$lastStepNumber))
            {
                $this->renderContent($userStep,$steps);
                return;
            }
            //получаем ответ компьютера
           $this->handleComputerStep($lastStepNumber);
        }

        $this->renderContent($userStep,$steps);
	}

    private function renderContent($userStep,$steps)
    {
        $userStep->cityName="";
        $this->render('create',array(
            'model'=>$userStep,
            'step'=>$steps,
        ));
        return true;
    }

    private function ifCityUndefined($userStep,$cityName)
    {
        if (City::model()->cityNotExist($cityName))
        {
            if(!WikiUtils::checkCityByWiki($cityName)&&!WikiUtils::checkCityByWiki($cityName."_(город)"))
            {
                $userStep->error = GameUtils::ERROR_CITY_UNDEFINED;
                return true;
            }

            $city = new City;
            $city->name = $cityName;
            $city->save();

            return false;
        }
    }

    private function checkAndSaveUserStep($userStep,$cityName,$lastStepNumber)
    {
        if($lastStepNumber > 1)
        {
            $userStep->error = GameUtils::checkUserStep($cityName);
        }
        //сохраняем ход игрока после проверки
        if($userStep->error == GameUtils::ERROR_SUCCESS)
        {
            $userStep->saveStep($cityName,$lastStepNumber);
            return true;
        }
        //если ход не прошел проверку, возвращаем false
        return false;

    }

    private function handleComputerStep($stepNumber)
    {
        $answer = GameUtils::compAnswer();
        //если компьютер сдался
        if(isset($answer['message']))
        {
            Yii::app()->session['loser'] = GameUtils::COMP_LOSER;
            $this->redirect(array('game/delete','id'=>Yii::app()->session['gameId']));
        }
        //иначе сохраняем ход компьютера
        $compstep = new Gamestep;
        $compstep->saveStep( $answer['city'], $stepNumber+1);

        return;
    }
}
