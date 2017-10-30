<?php

namespace Lib\Core;

/**
 * Class Util
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Util
{
    /**
     * Returns the requested value form the array with the given value as key. If the key is not set, the default will
     * be returned
     *
     * @param array       $array
     * @param mixed|array $values
     * @param mixed       $default
     * @return mixed
     */
    public static function arrayGet($array, $values, $default = null)
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        $cur = $array;
        foreach ($values as $value) {
            if (isset($cur[$value])) {
                $cur = $cur[$value];
            } else {
                return $default;
            }
        }

        return $cur;
    }

    /**
     * @param $text
     * @return string
     */
    public static function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
} 
