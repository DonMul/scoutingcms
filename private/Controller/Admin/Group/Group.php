<?php

namespace Controller\Admin\Group;

/**
 * Class Group
 * @package Controller\Admin\Group
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Group extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $group = \Lib\Data\Speltak::getById($_GET['id']);
        $this->ensurePermission('group.' . $group->getName() . '.view');

        return [
            'speltak' => $group,
            'active' => 'group'
        ];
    }
}
