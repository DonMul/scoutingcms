<?php

namespace Lib\Core;

/**
 * Class Validate
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Validate extends \Lib\Core\Singleton
{
    /**
     * Checks whether or not the given variable is empty
     *
     * @param string $variable
     * @return string
     */
    public function notEmpty($variable)
    {
        return !empty($variable);
    }

    /**
     * @param $variable
     * @return bool
     */
    public function isEmpty($variable)
    {
        return !$this->notEmpty($variable);
    }

    /**\
     * @param $variable
     * @param $minLength
     * @return bool
     */
    public function isMinLength($variable, $minLength)
    {
        return strlen($variable) >= $minLength;
    }

    /**
     * @param $variable
     * @param $maxLength
     * @return bool
     */
    public function isMaxLength($variable, $maxLength)
    {
        return strlen($variable) <= $maxLength;
    }

    /**
     * @param $variable
     * @return bool
     */
    public function isValidPassword($variable)
    {
        $matches = preg_match('@[A-Z]@', $variable);
        $matches &= preg_match('@[a-z]@', $variable);
        $matches &= preg_match('@[0-9]@', $variable);
        $matches &= strlen($variable) > 8;

        return !!$matches;
    }

    public function isValidEmailAddress($variable)
    {
        return !filter_var($variable, FILTER_VALIDATE_EMAIL) === false;
    }
}
