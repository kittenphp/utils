<?php


namespace kitten\utils;


use RuntimeException;

/**
 * LIFO Class
 */
class StackArray
{
    /** @var array */
    protected $array;

    public function __construct()
    {
        $this->array = [];
    }

    /**
     * @param $item
     */
    public function push($item)
    {
        array_unshift($this->array, $item);
    }

    /**
     * @return int
     */
    public function count():int
    {
        return count($this->array);
    }

    /**
     * @return mixed
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new RunTimeException('Stack is empty!');
        } else {
            return array_shift($this->array);
        }
    }

    /**
     * @return bool
     */
    public function isEmpty():bool
    {
        return empty($this->array);
    }

    /**
     * @return mixed
     */
    public function top()
    {
        return current($this->array);
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        return $this->array;
    }

    public function clear()
    {
        $this->array = [];
    }

}