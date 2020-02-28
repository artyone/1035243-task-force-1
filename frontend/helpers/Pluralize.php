<?php


namespace frontend\helpers;

/**
 * Класс-помощник получения склонения слов в зависимости от числительного перед ними
 * Class Pluralize
 * @package frontend\helpers
 */
class Pluralize
{
    const HOURS_IN_DAY = 24;
    const MINUTES_IN_HOUR = 60;
    const SECONDS_IN_MINUTE = 60;

    /**
     * Метод вычисления склонения слова в зависимости от числительного перед ним
     * @param int|null $number число перед словом
     * @param array $declensions массив склонений слова для числительных (1, 4, 5)
     * @return string
     */
    function getWordPluralize(?int $number, array $declensions): string
    {

        if ($number % 100 >= 11 && $number % 100 <= 19) {
            $string = $declensions[2];
        } else {
            switch ($number % 10) {
                case (1):
                    $string = $declensions[0];
                    break;
                case (2):
                case (3):
                case (4):
                    $string = $declensions[1];
                    break;
                default:
                    $string = $declensions[2];
            }
        }
        return $number . " $string";
    }

    /**
     * Метод для получения правильного склонения слов "минута", "час" и "день" в зависимости от количества времени
     * @param string|null $time строка времени
     * @return string количество времени и подходящее слово с правильным склонением
     */
    static function getStringTimeAgo(?string $time): string
    {
        $wordDeclinationMinutes = [' минуту', ' минуты', ' минут'];
        $wordDeclinationHours = [' чаc', ' часа', ' часов'];
        $wordDeclinationDays = [' день', ' дня', ' дней'];

        $seconds = strtotime("now") - strtotime($time);
        $minutes = $seconds / Pluralize::SECONDS_IN_MINUTE;
        if ($minutes < Pluralize::MINUTES_IN_HOUR) {
            $string = new Pluralize();
            $result = $string->getWordPluralize((int)$minutes, $wordDeclinationMinutes);
            return $result;
        }
        $hours = $minutes / Pluralize::MINUTES_IN_HOUR;
        if ($hours < Pluralize::HOURS_IN_DAY) {
            $string = new Pluralize();
            $result = $string->getWordPluralize((int)$hours, $wordDeclinationHours);
            return $result;
        }
        $days = $hours / Pluralize::HOURS_IN_DAY;
        $string = new Pluralize();
        $result = $string->getWordPluralize((int)$days, $wordDeclinationDays);

        return $result;

    }

    /**
     * Метод для получения правильного склонения слова "отзыв" в зависимости от числительного перед ним.
     * @param int|null $number число отзывов
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringFeedbacks(?int $number): string
    {
        $wordDeclination = [' отзыв', ' отзыва', ' отзывов'];
        $string = new Pluralize();
        $result = $string->getWordPluralize($number, $wordDeclination);
        return $result;
    }

    /**
     * Метод для получения правильного склонения слова "задание" в зависимости от числительного перед ним.
     * @param int|null $number число заданий
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringTasks(?int $number): string
    {
        $wordDeclination = [' задание', ' задания', ' заданий'];
        $string = new Pluralize();
        $result = $string->getWordPluralize($number, $wordDeclination);
        return $result;
    }
}