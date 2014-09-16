<?php

    class Session
    {
        //создание сессии
        public static function getSession()
        {
            //если в куки есть сохраненная сессия и она есть в базе
            if(isset($_COOKIE['gameId'])&&Game::model()->gameExists($_COOKIE['gameId']))
            {
                $sessionId = $_COOKIE['gameId'];
            }
            else
            {
                //добавить новую игру в таблицу Game, записать в куки новый id
                $sessionId = Game::model()->gameCreate();
                setcookie('gameId',$sessionId);
            }
			Yii::app()->session['gameId'] = $sessionId;
            return true;
        }
        //удаление сессии
        public static function deleteSession()
        {
            setcookie('gameId',Yii::app()->session['gameId'],time()-3600);
            return true;
        }
    }
?>