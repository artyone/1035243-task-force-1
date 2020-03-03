<?php


namespace frontend\formatter;


class TimeFormatter
{
    const HOURS_IN_DAY = 24;
    const MINUTES_IN_HOUR = 60;
    const SECONDS_IN_MINUTE = 60;

    private $timeDiff;

    public function __construct($time)
    {
        $this->timeDiff = strtotime('now') - strtotime($time);
    }

    public function getDays() :int
    {
        $result = $this->timeDiff / self::HOURS_IN_DAY / self::MINUTES_IN_HOUR / self:: SECONDS_IN_MINUTE;
        return (int)$result;
    }

    public function getHours() :int
    {
        $result = $this->timeDiff / self::MINUTES_IN_HOUR / self:: SECONDS_IN_MINUTE;
        if ($result < self::HOURS_IN_DAY) {
            return (int)$result;
        }
        return 0;
    }

    public function getMinutes() :int
    {
        $result = $this->timeDiff /  self:: SECONDS_IN_MINUTE;
        if ($result < self::MINUTES_IN_HOUR) {
            return (int)$result;
        }
        return 0;
    }

}