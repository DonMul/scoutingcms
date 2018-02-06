<?php

namespace Controller\Admin\Group;

use Controller\Admin;

/**
 * Class Group
 * @package Controller\Admin\Group
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Group extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $group = $this->getSpeltakRepository()->getById($this->getVariable('id', 0));
        $this->ensurePermission('group.' . $group->getName() . '.view');

        return [
            'speltak' => $group,
            'active' => 'group'
        ];
    }
}
