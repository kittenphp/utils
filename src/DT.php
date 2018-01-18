<?php


namespace kitten\utils;


class DT
{
    /** @var int */
    private $timeStamp = 0;

    /**
     * @param int $timeStamp
     */
    private function __construct(int $timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * @return DT
     */
    public static function now():DT
    {
        $stamp = time();
        $dateTime = new DT($stamp);
        return $dateTime;
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DT
     */
    public static function create(int $year,int $month,int $day,int $hour = 0,int $minute = 0,int $second = 0):DT
    {
        $stamp = mktime($hour, $minute, $second, $month, $day, $year);
        $dateTime = new DT($stamp);
        return $dateTime;
    }

    /**
     * @param int $timeStamp
     * @return DT
     */
    public static function createFormTimestamp(int $timeStamp):DT
    {
        return new DT($timeStamp);
    }

    /**
     * @param string $time
     * @return DT
     */
    public static function createFromString(string $time):DT
    {
        $stamp = strtotime($time);
        return new DT($stamp);
    }

    /**
     * @return int
     */
    public function getYear():int
    {
        $str = date('Y', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @return int
     */
    public function getMonth():int
    {
        $str = date('m', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @return int
     */
    public function getDay():int
    {
        $str = date('d', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @return int
     */
    public function getHour():int
    {
        $str = date('H', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @return int
     */
    public function getMinute():int
    {
        $str = date('i', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @return int
     */
    public function getSecond():int
    {
        $str = date('s', $this->timeStamp);
        return (int)$str;
    }

    /**
     * @param string $format
     * @return string
     */
    public function toFormatString(string $format = 'Y-m-d H:i:s'):string
    {
        return date($format, $this->timeStamp);
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @return bool
     */
    public static function checkDate(int $year,int $month,int $day):bool
    {
        return checkdate($month, $day, $year);
    }

    public function __toString()
    {
        return date('Y-m-d H:i:s', $this->timeStamp);
    }

    /**
     * @return int
     */
    public function getTimeStamp():int
    {
        return $this->timeStamp;
    }

    /**
     * @param int $value
     * @return DT
     */
    public function addDays(int $value):DT
    {
        $newTimeStamp = strtotime("+{$value} day", $this->timeStamp);
        return new DT($newTimeStamp);
    }

    /**
     * @param int $value
     * @return DT
     */
    public function addMonths(int $value):DT
    {
        $newTimeStamp = strtotime("+{$value} month", $this->timeStamp);
        return new DT($newTimeStamp);
    }

    /**
     * @param int $value
     * @return DT
     */
    public function addMinutes(int $value):DT
    {
        $newTimeStamp = $value * 60 + $this->timeStamp;
        return new DT($newTimeStamp);
    }

    /**
     * @param DT $startTime
     * @param DT $endTime
     * @return int
     */
    public static function getTimeSpan(DT $startTime, DT $endTime):int
    {
        $result = $endTime->timeStamp - $startTime->timeStamp;
        return $result;
    }

    /**
     * @param DT $startTime
     * @param AgoLocal|null $local
     * @return string
     */
    public static function ago(DT $startTime, AgoLocal $local = null):string
    {
        if (empty($local)) {
            $local = new AgoLocal();
        }
        $now = self::now();
        $span = self::getTimeSpan($startTime, $now);
        if ($span <= 60) {
            $time_result = $span . " {$local->getSecondsAgo()}";
        } elseif ($span <= 60 * 60) {
            $time_result = floor($span / 60) . " {$local->getMinutesAgo()}";

        } elseif ($span <= (60 * 60 * 24 * 1)) {
            $time_result = floor($span / 3600) . " {$local->getHoursAgo()}";

        } elseif ($span <= (60 * 60 * 24 * 4)) {
            $time_result = floor($span / 3600 / 24) . " {$local->getDaysAgo()}";

        } else {
            $time_result = $startTime->toFormatString();
        }
        return $time_result;
    }
}