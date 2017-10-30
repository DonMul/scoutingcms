<?php

namespace Controller;


class Speltak extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $speltak = \Lib\Data\Speltak::getByName($_GET['name']);

        return [
            'speltak' => $speltak,
        ];
    }
}