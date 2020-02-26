<?php


namespace frontend\helpers;

/**
 * Класс-помощник для склонения слов после чисел
 * Class StringEndings
 * @package frontend\helpers
 */
class StringEndings
{
    const HOURS_IN_DAY = 24;
    const MINUTES_IN_HOUR = 60;

    /**
     * Метод вычисления склонения слова
     * @param int|null $number число перед словом
     * @param array $endings массив склонений слова
     * @param int $const число с максимально возможным значением числа
     * @return string
     */
    static function getEnding(?int $number, array $endings, int $const): string
    {
        if ($number < 1) {
            $string = $endings[0];
            return $string;
        }

        if ($number >= $const) {
            $string = $endings[4];
            return $string;
        }

        if ($number % 100 >= 11 && $number % 100 <= 19) {
            $string = $endings[3];
        } else {
            switch ($number % 10)
            {
                case (1): $string = $endings[1]; break;
                case (2):
                case (3):
                case (4): $string = $endings[2]; break;
                default: $string = $endings[3];
            }
        }
        return $number . " $string";
    }

    /**
     * Метод для получения строки склонений слова "минута" в зависимости от количества времени
     * Если прошло больше часа, то используется getStringHours
     * @param string|null $time строка времени
     * @return string
     */
    static function getStringMinutes(?string $time): string
    {
        $endingsSeconds = ['меньше минуты назад','минуту назад','минуты назад','минут назад','больше часа назад'];
        $minutes = strtotime("now") - strtotime($time);
        $minutes = (int)($minutes/60);
        if ($minutes >= self::MINUTES_IN_HOUR) {
            $string = self::getStringHours($time);
        } else {
            $string = self::getEnding($minutes, $endingsSeconds, self::MINUTES_IN_HOUR);
        }
        return $string;

    }

    /**
     * Метод для получения строки склонений слова "час" в зависимости от количества времени
     * @param string|null $time строка времи
     * @return string
     */
    static function getStringHours(?string $time): string
    {
        $endingHours = ['меньше часа назад',' час назад',' часа назад', ' часов назад', 'больше суток назад'];
        $hours = strtotime("now") - strtotime($time);
        $hours = (int)($hours/60/60);
        $string = self::getEnding($hours, $endingHours, self::HOURS_IN_DAY);
        return $string;
    }

    /**
     * Метод для получения строки склонений слова "отзыв" в зависимости от числа перед ним
     * @param int|null $number число отзывов
     * @return string
     */
    static function getStringFeedbacks(?int $number): string
    {
        $endingFeedback = ['нет отзывов',' отзыв',' отзыва', ' отзывов', ''];
        $string = self::getEnding($number, $endingFeedback, PHP_INT_MAX);
        return $string;
    }

    /**
     * Метод для получения строки склонений слова "задание" в зависимости от числа перед ним
     * @param int|null $number число заданий
     * @return string
     */
    static function getStringTasks(?int $number): string
    {
        $endingFeedback = ['нет заданий',' задание',' задания', ' заданий', ''];
        $string = self::getEnding($number, $endingFeedback, PHP_INT_MAX);
        return $string;
    }
}