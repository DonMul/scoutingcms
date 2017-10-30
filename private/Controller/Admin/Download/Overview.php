<?php

namespace Controller\Admin\Download;

use Controller\Admin;
use Lib\Data\Download;

/**
 * Class Overview
 * @package Controller\Admin\Download
 */
class Overview extends Admin
{
    public function getArray()
    {
        return [
            'downloads' => Download::getAll(),
        ];
    }
}