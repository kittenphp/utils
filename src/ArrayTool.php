<?php

namespace kitten\utils;


class ArrayTool
{
    /**
     * @param array $array
     * @return bool
     */
    public static function isMultiArray(array $array):bool
    {
        //https://stackoverflow.com/questions/145337/checking-if-array-is-multidimensional-or-not
        if (count($array) == count($array, COUNT_RECURSIVE)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param array $array
     * @return bool
     */
    public static function isOneArray(array $array):bool
    {
        $result = self::isMultiArray($array);
        return !$result;
    }
}