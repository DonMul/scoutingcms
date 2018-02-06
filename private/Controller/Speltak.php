<?php

namespace Controller;

/**
 * Class Speltak
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Speltak extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'speltak' => $this->getSpeltakRepository()->getByName($this->getVariable('name', '')),
        ];
    }
}
