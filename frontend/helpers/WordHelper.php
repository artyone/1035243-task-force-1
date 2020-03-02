<?php


namespace frontend\helpers;

use frontend\formatter\MinutesFormatter;
use frontend\formatter\HoursFormatter;
use frontend\formatter\DaysFormatter;
use frontend\formatter\FeedbacksFormatter;
use frontend\formatter\TasksFormatter;
use frontend\formatter\TimeFormatter;


class WordHelper
{

    /**
     * Метод для получения правильного склонения существительных "минута", "час" и "день" в зависимости от количества времени
     * @param string|null $time строка времени
     * @return string количество времени и подходящее слово с правильным склонением
     */
    static function getStringTimeAgo(?string $time): string
    {
        $timeFormatter = new TimeFormatter($time);
        if ($num = $timeFormatter->getMinutes()) {
            $word = new MinutesFormatter($num);
            $result = $word->getWordForm();
            return $result;
        }
        if ($num = $timeFormatter->getHours()) {
            $word = new HoursFormatter($num);
            $result = $word->getWordForm();
            return $result;
        }
        $num = $timeFormatter->getDays();
        $word = new DaysFormatter($num);
        $result = $word->getWordForm();
        return $result;
    }

    /**
     * Метод для получения правильного склонения существительного "отзыв" в зависимости от числительного перед ним.
     * @param int|null $number число отзывов
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringFeedbacks(?int $number): string
    {
        $word = new FeedbacksFormatter($number);
        $result = $word->getWordForm();
        return $result;
    }

    /**
     * Метод для получения правильного склонения существительного "задание" в зависимости от числительного перед ним.
     * @param int|null $number число заданий
     * @return string количество заданий и существительное в правильном склонении
     */
    static function getStringTasks(?int $number): string
    {
        $word = new TasksFormatter($number);
        $result = $word->getWordForm();
        return $result;
    }
}