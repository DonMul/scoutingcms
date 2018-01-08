<?php

namespace Controller\Admin\Agenda;

use Lib\Data\AgendaCategory;

/**
 * Class AgendaItem
 * @package Controller\Admin\Agenda
 */
class AgendaItem extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');
        $item = \Lib\Data\Agenda::getById($_GET['id']);
        if ($item === null) {
            $item = new \Lib\Data\Agenda(
                null,
                "Nieuw agenda item",
                date('Y-m-d H:i:d'),
                date('Y-m-d H:i:d'),
                "",
                '',
                ''
            );
        }

        return [
            'item' => $item,
            'categories' => AgendaCategory::getAll(),
            'active' => 'calender',
            'isNew' => $item->getId() == null,
        ];
    }
}