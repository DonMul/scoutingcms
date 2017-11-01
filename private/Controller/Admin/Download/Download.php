<?php

namespace Controller\Admin\Download;

use Controller\Admin;

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
                "New Download",
                \Lib\Data\Download::TYPE_REPORT,
                ''
            );
        } else {
            $this->ensurePermission('download.' . $download->getType() . '.view');
        }

        return [
            'download' => $download,
            'active' => 'download'
        ];
    }
}