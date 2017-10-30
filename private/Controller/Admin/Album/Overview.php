<?php

namespace Controller\Admin\Album;

use Lib\Core\BaseController;
use Lib\Data\Album;

/**
 * Class Overview
 * @package Controller\Admin\Album
 */
class Overview extends BaseController
{
    /**
     *
     */
    public function getArray()
    {
        return [
            'albums' => Album::getAll()
        ];
    }
}