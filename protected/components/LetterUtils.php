<?php
    class LetterUtils
    {

        //массив запрещенных букв
        private static $prohibitedLetters = array('ы','ь','ё','й');
        //функция проверяет, не является ли буква запрещенной
        public static function letterIsProhibited($letter)
        {
            for ($i = 0; $i < count(self::$prohibitedLetters); $i++){
                if ( $letter == self::$prohibitedLetters[$i] ){
                    return true;
                }
            }
            return false;
        }

        //функция возвращает последнюю букву в слове(незапрещенную)
        public static function getLastLetter($word)
        {
            $i = 1;
            $len = mb_strlen($word);

            do {
                $lastLetter = mb_substr($word, $len - $i, 1);
            } while( self::letterIsProhibited($lastLetter) );

            return $lastLetter;
        }

        //проверка соответствия последней буквы последнего хода и первой буквы нового хода
        public static function checkLastAndFirstLetter($word)
        {
            $lastLetter = Gamestep::model()->getLastLetter();
            $firstLetter = mb_substr($word, 0, 1);
            if( $firstLetter !== $lastLetter ){
                return false;
            }

            return true;
        }

    }
?>