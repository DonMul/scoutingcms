<?php

namespace Controller\Services\Admin\Download;

use Lib\Core\Translation;
use Lib\Data\Download;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $downloadId = $this->getPostValue('itemId');
        $download = Download::getById($downloadId);
        if (!($download instanceof Download) && intval($downloadId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.download.notFound", ['id' => $downloadId]));
        }

        $this->ensurePermission('download.' . $this->getPostValue('type') . '.edit');

        if ($download) {
            $download->setName($this->getPostValue('name'));
            $download->setType($this->getPostValue('type'));
        } else {
            $download = new Download(
                null,
                $this->getPostValue('name'),
                $this->getPostValue('type'),
                ''
            );
        }

        if (!empty($_FILES['file']['name'])) {
            if (!is_dir($_SERVER["DOCUMENT_ROOT"] . 'public/downloads/' . $download->getType() . '/')) {
                mkdir($_SERVER["DOCUMENT_ROOT"] . 'public/downloads/' . $download->getType() . '/');
            }

            $targetName = $_SERVER["DOCUMENT_ROOT"] . 'public/downloads/' . $download->getType() . '/' . $_FILES['file']['name'];
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetName)) {
                throw new \Exception("Could not upload file");
            }

            $cdnData = \Lib\Core\Settings::getInstance()->get('cdn');
            if (\Lib\Core\Util::arrayGet($cdnData, 'enabled', false) === true) {
                $ftp = new \Lib\Ftp\Client(
                    $cdnData['host'],
                    $cdnData['username'],
                    $cdnData['password']
                );

                $ftp->upload(realpath($targetName), str_replace('/subdomains/scoutingflg/public/', '', realpath($targetName)));
            }

            $download->setFilename($_FILES['file']['name']);
        }

        $download->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminDownloads")
        ];
    }
}
