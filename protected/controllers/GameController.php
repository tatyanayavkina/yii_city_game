<?php

class GameController extends Controller
{

    public $defaultAction = 'start';
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
        $this->redirect(array('end'));
	}

    public function actionStart()
    {
        //получаем id игры
        Session::getSession();
        Yii::app()->session['loser']=GameUtils::USER_LOSER;
        //переходим на страницу с игрой
        $this->redirect(array('gamestep/create'));
    }

    public function actionEnd()
    {
        Session::deleteSession();
        $this->render('end');
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Game the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Game::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
