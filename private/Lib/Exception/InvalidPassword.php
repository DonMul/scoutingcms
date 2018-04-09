<?php

namespace Lib\Exception;

use Lib\Core\Translation;

/**
 * Class InvalidPassword
 * @package Lib\Exception
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class InvalidPassword extends UserException
{
    /**
     * InvalidPassword constructor.
     */
    public function __construct()
    {
        parent::__construct(Translation::getInstance()->translate('error.passwordNotStrongEnough'));
    }
}
