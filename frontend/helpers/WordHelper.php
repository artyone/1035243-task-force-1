<?php


namespace frontend\helpers;

use frontend\formatter\MinutesFormatter;
use frontend\formatter\HoursFormatter;
use frontend\formatter\DaysFormatter;
use frontend\formatter\FeedbacksFormatter;
use frontend\formatter\MonthFormatter;
use frontend\formatter\TasksFormatter;
use frontend\formatter\YearFormatter;


class WordHelper
{

    /**
     * Метод для получения правильного склонения существительных "минута", "час" и "день" в зависимости от количества времени
     * @param string|null $time строка времени
     * @return string количество времени и подходящее слово с правильным склонением
     */
    static function getStringTimeAgo(?string $time): string
    {

        $interval = date_create('now')->diff(date_create($time));
        if ($interval->y >= 1) {
            $word = new YearFormatter($interval->y);
            return $word->getWordForm();
        }
        if ($interval->m >= 1) {
            $word = new MonthFormatter($interval->m);
            return $word->getWordForm();
        }
        if ($interval->d >= 1) {
            $word = new DaysFormatter($interval->d);
            return $word->getWordForm();
        }
        if ($interval->h >= 1) {
            $word = new HoursFormatter($interval->h);
            return $word->getWordForm();
        }
        if ($interval->i >= 1) {
            $word = new MinutesFormatter($interval->i);
            return $word->getWordForm();
        }
        return '';
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