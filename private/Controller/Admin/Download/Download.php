<?php

namespace Controller\Admin\Download;

use Controller\Admin;
use Lib\Core\Translation;

/**
 * Class Download
 * @package Controller\Admin
 */
class Download extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $download = \Lib\Data\Download::getById($_GET['id']);
        if (!$download) {
            $download = new \Lib\Data\Download(
                null,
                Translation::getInstance()->translate('download.name'),
                \Lib\Data\Download::TYPE_REPORT,
                ''
            );
        } else {
            $this->ensurePermission('download.' . $download->getType() . '.view');
        }

        return [
            'download' => $download,
            'active' => 'download',
            'isNew' => $download->getId() == null,
        ];
    }
}