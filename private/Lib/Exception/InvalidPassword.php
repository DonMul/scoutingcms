<?php

namespace Lib\Exception;

use Lib\Core\Translation;

/**
 * Class InvalidPassword
 * @package Lib\Exception
 */
class InvalidPassword extends \Exception
{
    public function __construct()
    {
        parent::__construct(Translation::getInstance()->translate('error.passwordNotStrongEnough'));
    }
}
