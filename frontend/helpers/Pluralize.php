<?php


namespace frontend\helpers;


/**
 * Класс-помощник для получения склонений существительных в зависимости от числительного перед ними
 * Class Pluralize
 * @package frontend\helpers
 */
class Pluralize
{
    const HOURS_IN_DAY = 24;
    const MINUTES_IN_HOUR = 60;
    const SECONDS_IN_MINUTE = 60;

    /**
     * @var array массив склонений необходимых слов для числительных (1, 4, 5)
     */
    private $wordDeclination = [
        'minutes' => [' минуту', ' минуты', ' минут'],
        'hours' => [' чаc', ' часа', ' часов'],
        'days' => [' день', ' дня', ' дней'],
        'feedbacks' => [' отзыв', ' отзыва', ' отзывов'],
        'tasks' => [' задание', ' задания', ' заданий']
    ];

    /**
     * Метод получения параметров для подсчета склонения существительных связанных со временем
     * @param string|null $time
     * @return array
     */
    public function getParamTime(?string $time): array
    {
        $seconds = strtotime("now") - strtotime($time);
        $minutes = $seconds / self::SECONDS_IN_MINUTE;
        if ($minutes < self::MINUTES_IN_HOUR) {
            return [$minutes, 'minutes'];
        }
        $hours = $minutes / self::MINUTES_IN_HOUR;
        if ($hours < self::HOURS_IN_DAY) {
            return [$hours, 'hours'];
        }
        $days = $hours / self::HOURS_IN_DAY;
        return [$days, 'days'];
    }
    /**
     * Метод вычисления склонения слова в зависимости от числительного перед ним
     * @param int|null $number число перед словом
     * @return string
     */
    public function getWordPluralize(?int $number, string $word): string
    {

        if ($number % 100 >= 11 && $number % 100 <= 19) {
            $string = $this->wordDeclination[$word][2];
        } else {
            switch ($number % 10) {
                case (1):
                    $string = $this->wordDeclination[$word][0];
                    break;
                case (2):
                case (3):
                case (4):
                    $string = $this->wordDeclination[$word][1];
                    break;
                default:
                    $string = $this->wordDeclination[$word][2];
            }
        }
        return $number . " $string";
    }

    /**
     * Метод для получения правильного склонения существительных "минута", "час" и "день" в зависимости от количества времени
     * @param string|null $time строка времени
     * @return string количество времени и подходящее слово с правильным склонением
     */
    static function getStringTimeAgo(?string $time): string
    {
        $string = new Pluralize();
        $param = $string->getParamTime($time);
        $result = $string->getWordPluralize((int)$param[0], $param[1]);
        return $result;
    }

    /**
     * Метод для получения правильного склонения существительного "отзыв" в зависимости от числительного перед ним.
     * @param int|null $number число отзывов
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringFeedbacks(?int $number): string
    {
        $string = new Pluralize();
        $result = $string->getWordPluralize($number, 'feedbacks');
        return $result;
    }

    /**
     * Метод для получения правильного склонения существительного "задание" в зависимости от числительного перед ним.
     * @param int|null $number число заданий
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringTasks(?int $number): string
    {
        $string = new Pluralize();
        $result = $string->getWordPluralize($number, 'tasks');
        return $result;
    }
}