<?php

namespace Controller;

/**
 * Class Download
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Download extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'downloads' => $this->getDownloadRepository()->findByType($this->getVariable('type', '')),
        ];
    }
}
