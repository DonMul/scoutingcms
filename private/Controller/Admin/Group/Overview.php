<?php

namespace Controller\Admin\Group;

use Controller\FourOFour;

/**
 * Class Admin
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends \Controller\Admin
{

    /**
     * @return array
     */
    public function getArray()
    {
        $groups = $this->getSpeltakRepository()->getAll();
        $allowed = false;
        foreach ($groups as $key => $group) {
            if ($this->hasPermission('group.' . $group->getName() . '.view')) {
                $allowed = true;
            } else {
                unset($groups[$key]);
            }
        }

        if (!$allowed) {
            header("HTTP/1.1 404 Not Found");
            $controller = new FourOFour();
            $controller->execute();
            exit;
        }

        $this->ensurePermission('news.edit');

        return [
            'speltakken' => $groups,
            'active' => 'group',
        ];
    }
}
