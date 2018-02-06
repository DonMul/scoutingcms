<?php

namespace Controller\Services\Admin\Agenda;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Agenda;

/**
 * Class Delete
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Delete extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $itemId = $this->getPostValue('itemId');
        $item = $this->getAgendaRepository()->getById($itemId);

        if (!($item instanceof Agenda)) {
            throw new \Exception(Translation::getInstance()->translate("error.item.notFound", ['id' => $itemId]));
        }

        $this->getAgendaRepository()->delete($item);

        return [
            'reload' => true,
        ];
    }
}
