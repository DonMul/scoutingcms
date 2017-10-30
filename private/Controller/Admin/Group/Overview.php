<?php

namespace Controller\Admin\Group;

/**
 * Class Admin
 * @package Controller
 * @author Joost Mul
 */
class Overview extends \Controller\Admin
{

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'speltakken' => \Lib\Data\Speltak::getAll()
        ];
    }
}