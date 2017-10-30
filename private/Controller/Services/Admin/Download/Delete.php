<?php

namespace Controller\Services\Admin\Download;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Download;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Delete extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $downloadId = $this->getPostValue('itemId');
        $download = Download::getById($downloadId);
        if (!($download instanceof Download)) {
            throw new \Exception(Translation::getInstance()->translate("error.download.notFound", ['id' => $downloadId]));
        }

        $download->delete();

        return [
            'reload' => true,
        ];
    }
}