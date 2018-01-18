<?php


namespace kitten\utils;


class StringTools
{
    /**
     * @return string
     */
    public static function uuid():string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0C2f) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );
    }

    /**
     * @param string $text
     * @param bool $isMulti
     * @return bool
     */
    public static function isNullOrEmptyString(string $text,bool $isMulti=false):bool
    {
        //https://stackoverflow.com/questions/381265/better-way-to-check-variable-for-null-or-empty-string
        if ($isMulti){
            return (!isset($text) ||  self::trim($text) === '');
        }else{
            return (!isset($text) ||  trim($text) === '');
        }
    }

    /**
     * @param string $text
     * @return string
     */
    public static function trim(string $text):string
    {
        return preg_replace('/(^\s+)|(\s+$)/u', '', $text);
    }

    /**
     * @param string $text
     * @param string $start
     * @return bool
     */
    public static function startsWith(string $text,string $start):bool
    {
        //https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
        $length = mb_strlen($start);
        $part = mb_substr($text, 0, $length);
        if (strcasecmp($part, $start) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $text
     * @param string $subStr
     * @return bool
     */
    public static function isContain(string $text,string $subStr):bool {
        if (mb_stristr($text,$subStr)===false){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param string $text
     * @param string $end
     * @return bool
     */
    public static function endsWith(string $text,string $end):bool
    {
        //https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
        $length = mb_strlen($end);
        $part = mb_substr($text, -$length);
        if (strcasecmp($part, $end) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $text
     * @param int $length
     * @return string
     */
    public static function trimRightCount(string $text,int $length):string
    {
        $result = mb_substr($text, 0, -$length);
        if ($result === false) {
            return $text;
        } else {
            return $result;
        }
    }

    /**
     * @param string $text
     * @param int $length
     * @return string
     */
    public static function trimLeftCount(string $text,int $length):string
    {
        $result = mb_substr($text, $length);
        if ($result === false) {
            return $text;
        } else {
            return $result;
        }
    }

    /**
     * @param string $text
     * @param int $length
     * @param bool $suffix
     * @return string
     */
    public static function subtext(string $text,int $length,bool $suffix=true){
        if(mb_strlen($text, 'utf8') > $length){
            if($suffix){
                return mb_substr($text, 0, $length, 'utf8').'...';
            }else{
                return mb_substr($text, 0, $length, 'utf8');
            }
        }
        return $text;
    }


    /**
     * @param string $text
     * @param string $left
     * @return string
     */
    public static function trim_left(string $text,string $left):string
    {
        if (self::startsWith($text, $left)) {
            return self::trimLeftCount($text, mb_strlen($left));
        } else {
            return $text;
        }
    }

    /**
     * @param string $text
     * @param string $right
     * @return string
     */
    public static function trim_right(string $text,string $right):string
    {
        if (self::endsWith($text, $right)) {
            return self::trimRightCount($text, mb_strlen($right));
        } else {
            return $text;
        }
    }

    /**
     * Converts UTF-8 string to lower case.
     * @param string $text
     * @return string
     */
    public static function lower(string $text):string
    {
        return mb_strtolower($text, 'UTF-8');
    }

    /**
     *  Converts UTF-8 string to upper case.
     * @param string $text
     * @return string
     */
    public static function upper(string $text):string
    {
        return mb_strtoupper($text, 'UTF-8');
    }

    /**
     * Returns number of characters (not bytes) in UTF-8 string.
     * That is the number of Unicode code points which may differ from the number of graphemes.
     * @param string $text
     * @return int
     */
    public static function length(string $text):int
    {
       return mb_strlen($text, 'UTF-8');
    }


    /**
     * Takes an integer value and returns an formatted string. For example 1024 -> 1 KiB
     *
     * @param integer $bytes
     *
     * @throws \OutOfRangeException
     * @return string
     */
    public static function format_bytes(int $bytes):string
    {
        $bytes = (double)abs($bytes);
        if ($bytes === 0.0) {
            return '0.00 B';
        }
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $index = (int)(log($bytes) / log(1024));
        if ($index > 8) {
            throw new \OutOfRangeException('Input is to large! Maximum supported: 1.236731113465765645724418048 * 10^27 bytes.');
        }
        if ($index === 0) {
            $output = sprintf('%.2f %s', $bytes, $units[$index]);
        } else {
            $output = sprintf('%.2f %s', ($bytes / pow(1024, $index)), $units[$index]);
        }
        return $output;
    }

    /**
     * Decodes `\uXXXX` entities into their real unicode character equivalents.
     *
     * @param string $text (Required) The string to decode.
     * @return string The decoded string.
     */
    public static function decode_uhex(string $text):string
    {
        preg_match_all('/\\\u([0-9a-f]{4})/i', $text, $matches);
        $matches = $matches[count($matches) - 1];
        $map = array();
        foreach ($matches as $match) {
            if (!isset($map[$match])) {
                $map['\u' . $match] = html_entity_decode('&#' . hexdec($match) . ';', ENT_NOQUOTES, 'UTF-8');
            }
        }
        return str_replace(array_keys($map), $map, $text);
    }

    /**
     * @param string $text
     * @param string $regular
     * @return bool
     */
    public static function match(string $text,string $regular):bool
    {
        if (preg_match($regular, $text) === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function match_email(string $email):bool
    {
        return self::match($email, '/([\w\-]+\@[\w\-]+\.[\w\-]+)/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_letter_Number(string $text):bool
    {
        return self::match($text, '/^[A-Za-z0-9]+$/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_letter(string $text):bool
    {
        return self::match($text, '/^[A-Za-z]+$/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_character(string $text):bool {
        return self::match($text,'/^\w+$/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_integer(string $text):bool
    {
        return self::match($text, '/^[0-9]*$/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_decimal(string $text):bool
    {
        return self::match($text, '/^[0-9]+(.[0-9]{2})?$/');
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_chinese(string $text):bool
    {
        return self::match($text, "/^[\x{4e00}-\x{9fa5}]+$/u");
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_phone(string $text):bool
    {
        return self::match($text, "/^1[34578]\d{9}$/");
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function match_ID_card(string $text):bool
    {
        $r1 = '/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/';
        $r2 = '/^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$/';
        if (self::match($text, $r1) || self::match($text, $r2)) {
            return true;
        } else {
            return false;
        }
    }
}