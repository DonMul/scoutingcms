<?php

namespace Controller\Agenda;

use Lib\Data\Agenda;
use Lib\Data\AgendaCategory;

/**
 * Class Item
 * @package Controller\Agenda
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Item extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $item = Agenda::getBySlug($_GET['slug']);

        return [
            'item' => $item,
            'category' => AgendaCategory::getById($item->getCategory()),
        ];
    }
}
