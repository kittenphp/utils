<?php


namespace kitten\utils;


class RandomTools
{
    /**
     * @param int $length
     * @return string
     */
    public static function string(int $length = 5):string
    {
        $characters = 'abcdefhkmnprstuvwxyABCDEFGHKMNPRSTUVWXY345678';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    /**
     * @param int $startNum
     * @param int $endNum
     * @return int
     */
    public static function number(int $startNum=100000,int $endNum=999999):int {
        return mt_rand($startNum,$endNum);
    }
    /**
     * @return string
     */
    public static function token():string {
        return  md5(uniqid(rand(), TRUE));
    }
}