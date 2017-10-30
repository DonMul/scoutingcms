<?php

namespace Controller\Services\Admin\Agenda;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Agenda;

/**
 * Class Delete
 * @package Controller\Services\User
 */
class Delete extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $itemId = $this->getPostValue('itemId');
        $item = Agenda::getById($itemId);

        if (!($item instanceof Agenda)) {
            throw new \Exception(Translation::getInstance()->translate("error.item.notFound", ['id' => $itemId]));
        }

        $item->delete();

        return [
            'reload' => true,
        ];
    }
}