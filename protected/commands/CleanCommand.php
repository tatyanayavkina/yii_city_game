<?php
Class CleanCommand extends CConsoleCommand
{
    // 1 неделя = 604800000 ms
    const ONE_WEEK = 604800000;

    public function actionCleanHistory()
    {
        echo "Delete History";
        $minDate = time() - self::ONE_WEEK;

        $criteria = new CDbCriteria;
        $criteria->condition = 'lastStepDate < :minDate';
        $criteria->params = array(':minDate'=>$minDate);
        $oldGames = Game::model()->findAll($criteria);

        foreach($oldGames as $oldGame)
        {
            echo "Delete game with id=".$oldGame->id;
            $oldGame->delete();
        }
        return true;
    }
}
?>