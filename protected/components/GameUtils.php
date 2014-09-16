<?php

    class GameUtils
    {
        const COMP_LOSER = "Мой создатель глуп и невежественнен. Я сдаюсь!";
        const USER_LOSER= "Вы проиграли! Попробуйте еще раз.";
        const ERROR_CITY_UNDEFINED = "Такого города не существует!";
        const ERROR_CITY_USED = "Город уже использован в игре, придумайте другой";
        const ERROR_CITY_LETTER = "Город должен начинаться с буквы";
        const ERROR_SUCCESS = "Ошибок нет";
        const COMP_STEP_OWNER = "Сейчас ход компьютера";
        const USER_STEP_OWNER = "Сейчас Ваш ход";

        //поиск города в бд, который не был использован в игре
        private static function findCityIsNotInGame($possibleCities){
            $usedCities = Gamestep::model()->citiesUsedInGame();
            foreach ($usedCities as $usedCity) {
                if (array_key_exists($usedCity, $possibleCities)) {
                    unset($possibleCities[$usedCity]);
                }
            }

            //если таких городов нет, то возвращаем -1
            if(empty($possibleCities))
            {
                return -1;
            }

            $randomIndex = mt_rand(0, count($possibleCities) - 1);
            $possibleCitiesWithNumericIndexes = array_keys($possibleCities);
            return $possibleCitiesWithNumericIndexes[$randomIndex];
        }

        //формирует ответ компьютера
        public static function compAnswer()
        {
            $answer = array();
            $lastLetter = Gamestep::model()->getLastLetter();
            //запрос, все выбранные города помещаются в массив $potentialAnswers
            $potentialAnswers = City::model()->findPossibleCities($lastLetter);
            //найти в $potentialAnswers город, еще не использованный в игре
            $firstCityIsNotInGame = self::findCityIsNotInGame($potentialAnswers);
            //сделать ход, или сдаться
            if ($firstCityIsNotInGame == -1){
                $answer['message'] = self::COMP_LOSER;
            }
            else{
                $answer['city'] =  $firstCityIsNotInGame;
            }
            return $answer;
        }

        //проверка хода игрока на ошибки
        public static function checkUserStep($userStep){
            $textError = self::ERROR_SUCCESS;
            if ( !LetterUtils::checkLastAndFirstLetter($userStep))
            {
                $textError = self::ERROR_CITY_LETTER." '" .Gamestep::model()->getLastLetter()."'";
            }

            if (Gamestep::model()->checkCityAlreadyExist($userStep)){
                $textError = self::ERROR_CITY_USED;
            }

            return $textError;
        }
    }
?>