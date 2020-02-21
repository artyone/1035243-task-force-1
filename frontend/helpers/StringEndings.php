<?php


namespace frontend\helpers;


class StringEndings
{
    const HOURS_IN_DAY = 24;
    const MINUTES_IN_HOUR = 60;

    static function getEnding($number, $endings, $const)
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

    static function getStringMinutes($time)
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

    static function getStringHours($time)
    {
        $endingHours = ['меньше часа назад',' час назад',' часа назад', ' часов назад', 'больше суток назад'];
        $hours = strtotime("now") - strtotime($time);
        $hours = (int)($hours/60/60);
        $string = self::getEnding($hours, $endingHours, self::HOURS_IN_DAY);
        return $string;
    }

    static function getStringFeedbacks($number)
    {
        $endingFeedback = ['нет отзывов',' отзыв',' отзыва', ' отзывов', ''];
        $string = self::getEnding($number, $endingFeedback, PHP_INT_MAX);
        return $string;
    }

    static function getStringTasks($number)
    {
        $endingFeedback = ['нет заданий',' задание',' задания', ' заданий', ''];
        $string = self::getEnding($number, $endingFeedback, PHP_INT_MAX);
        return $string;
    }
}