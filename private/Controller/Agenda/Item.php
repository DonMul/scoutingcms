<?php

namespace Controller\Agenda;

/**
 * Class Item
 * @package Controller\Agenda
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Item extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        $item = $this->getAgendaRepository()->getBySlug($_GET['slug']);

        return [
            'item' => $item,
            'category' => $this->getAgendaCategoryRepository()->getById($item->getCategory()),
        ];
    }
}
