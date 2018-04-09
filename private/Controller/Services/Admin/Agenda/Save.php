<?php

namespace Controller\Services\Admin\Agenda;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Agenda;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $itemId = intval($this->getPostValue('itemId'));
        $item = $this->getAgendaRepository()->getById($itemId);

        if (!($item instanceof Agenda) && intval($itemId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.item.notFound", ['id' => $itemId]));
        }

        if ($item) {
            $item->setName($this->getPostValue('name'));
            $item->setStartDate($this->getPostValue('startDate'));
            $item->setEndDate($this->getPostValue('endDate'));
            $item->setCategory($this->getPostValue('category'));
            $item->setDescription($this->getPostValue('description'));
        } else {
            $item = new Agenda(
                null,
                $this->getPostValue('name'),
                $this->getPostValue('startDate'),
                $this->getPostValue('endDate'),
                $this->getPostValue('description'),
                Util::slugify($this->getPostValue('name')),
                $this->getPostValue('category')
            );
        }

        $this->getAgendaRepository()->save($item);

        return [
            'redirect' => Translation::getInstance()->translateLink("adminCalender")
        ];
    }
}
