<?php

namespace Controller\Services\Admin\Agenda;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Agenda;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Save extends \Controller\Services\Admin
{
    public function getArray()
    {
        $this->ensurePermission('calender.edit');

        $itemId = $this->getPostValue('itemId');
        $item = Agenda::getById($itemId);

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

        $item->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminCalender")
        ];
    }
}