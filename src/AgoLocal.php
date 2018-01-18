<?php


namespace kitten\utils;


class AgoLocal
{
    protected $daysAgo='days ago';
    protected $secondsAgo='seconds ago';
    protected $minutesAgo='minutes ago';
    protected $hoursAgo='hours ago';

    /**
     * @return string
     */
    public function getDaysAgo():string
    {
        return $this->daysAgo;
    }

    /**
     * @param string $daysAgo
     */
    public function setDaysAgo(string $daysAgo)
    {
        $this->daysAgo = $daysAgo;
    }

    /**
     * @return string
     */
    public function getSecondsAgo():string
    {
        return $this->secondsAgo;
    }

    /**
     * @param string $secondsAgo
     */
    public function setSecondsAgo(string $secondsAgo)
    {
        $this->secondsAgo = $secondsAgo;
    }

    /**
     * @return string
     */
    public function getMinutesAgo():string
    {
        return $this->minutesAgo;
    }

    /**
     * @param string $minutesAgo
     */
    public function setMinutesAgo(string $minutesAgo)
    {
        $this->minutesAgo = $minutesAgo;
    }

    /**
     * @return string
     */
    public function getHoursAgo():string
    {
        return $this->hoursAgo;
    }

    /**
     * @param string $hoursAgo
     */
    public function setHoursAgo(string $hoursAgo)
    {
        $this->hoursAgo = $hoursAgo;
    }

}