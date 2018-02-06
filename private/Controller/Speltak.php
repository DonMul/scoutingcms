<?php

namespace Controller;

use Lib\Exception\PageNotFound;

/**
 * Class Speltak
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Speltak extends \Lib\Core\BaseController
{
    /**
     * @return array
     * @throws PageNotFound
     */
    public function getArray()
    {
        $speltak = $this->getSpeltakRepository()->getByName($this->getVariable('name', ''));

        if (!$speltak) {
            throw new PageNotFound();
        }

        return [
            'speltak' => $speltak,
        ];
    }
}
