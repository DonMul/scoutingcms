<?php

namespace Controller\Admin\Agenda;

use Lib\Data\AgendaCategory;

/**
 * Class AgendaItem
 * @package Controller\Admin\Agenda
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class AgendaItem extends \Controller\Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');
        $item = $this->getAgendaRepository()->getById($_GET['id']);
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
            'categories' => $this->getAgendaCategoryRepository()->getAll(),
            'active' => 'calender',
            'isNew' => $item->getId() == null,
        ];
    }
}
