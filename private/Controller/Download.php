<?php

namespace Controller;

class Download extends \Lib\Core\BaseController
{
    public function getArray()
    {
        return [
            'downloads' => \Lib\Data\Download::findByType($_GET['type']),
        ];
    }
}