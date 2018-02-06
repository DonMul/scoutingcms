<?php

namespace Controller\Admin\Download;

use Controller\Admin;
use Controller\FourOFour;

/**
 * Class Overview
 * @package Controller\Admin\Download
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Overview extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $downloads = $this->getDownloadRepository()->getAll();
        $allowed = true;

        foreach (['report', 'newsletter'] as $download) {
            if ($this->hasPermission('download.' . $download . '.view')) {
                $allowed = true;
            }
        }

        if (!$allowed) {
            header("HTTP/1.1 404 Not Found");
            $controller = new FourOFour();
            $controller->execute();
            exit;
        }

        return [
            'downloads' => $downloads,
            'active' => 'download'
        ];
    }
}
