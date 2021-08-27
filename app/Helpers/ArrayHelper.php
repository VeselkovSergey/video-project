<?php


namespace App\Helpers;


class ArrayHelper
{
    public static function ResetKey(array $array): array
    {
        foreach ($array as $key => $arr) {
            if (is_array($arr)) {
                $arr = self::ResetKey($arr);
                $array[$key] = array_values($arr);
            }
        }
        if (is_array($array)) {
            $array = array_values($array);
        }
        return $array;
    }

    public static function ReplaceChar(array $array, $search, string $replace): array
    {
        foreach ($array as $key => $arr) {
            if (is_array($arr)) {
                $arr = self::ReplaceChar($arr, $search, $replace);
                $array[$key] = array_values($arr);
            } else {
                $array[$key] = str_replace($search, $replace, $arr);
            }
        }
        if (is_array($array)) {
            $array = array_values($array);
        }
        return $array;
    }
}
