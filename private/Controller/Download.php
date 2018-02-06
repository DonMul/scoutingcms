<?php

namespace Controller;

/**
 * Class Download
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Download extends \Lib\Core\BaseController
{
    public function getArray()
    {
        return [
            'downloads' => \Lib\Data\Download::findByType($_GET['type']),
        ];
    }
}
