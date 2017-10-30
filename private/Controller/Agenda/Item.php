<?php

namespace Controller\Agenda;

use Lib\Data\Agenda;

class Item extends \Lib\Core\BaseController
{
    public function getArray()
    {
        $item = Agenda::getBySlug($_GET['slug']);

        return [
            'item' => $item,
        ];
    }
}