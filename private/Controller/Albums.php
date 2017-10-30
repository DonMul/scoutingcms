<?php

namespace Controller;


use Lib\Data\Album;

class Albums extends \Lib\Core\BaseController
{
    public function getArray()
    {
        return [
            'albums' => Album::findByCategory($_GET['category']),
        ];
    }
}