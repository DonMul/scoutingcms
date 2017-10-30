<?php

namespace Controller\Admin\Group;

/**
 * Class Group
 * @package Controller\Admin\Group
 */
class Group extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'speltak' => \Lib\Data\Speltak::getById($_GET['id'])
        ];
    }
}