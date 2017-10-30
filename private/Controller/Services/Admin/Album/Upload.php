<?php

namespace Controller\Services\Admin\Album;

use Lib\Core\BaseController;
use Lib\Data\Album;
use Lib\Data\Picture;

/**
 * Class Upload
 * @package Controller\Services\Admin\Album
 */
class Upload extends \Controller\Services\Admin
{
    /**
     * @return []
     */
    public function getArray()
    {
        $album = Album::getById($this->getPostValue('albumId'));
        if (!$album) {
            return [];
        }

        $targetDir = ROOT . "../public/upload/" . $album->getCategory() . "/" . md5($album->getName()) . '/';

        if (!is_dir(ROOT . "../public/upload/" . $album->getCategory())) {
            mkdir(ROOT . "../public/upload/" . $album->getCategory());
        }

        if (!is_dir(ROOT . "../public/upload/" . $album->getCategory() . "/" . md5($album->getName()))) {
            mkdir(ROOT . "../public/upload/" . $album->getCategory() . "/" . md5($album->getName()));
        }

        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);

        $picture = new Picture(
            null,
            $album->getId(),
            basename($_FILES["file"]["name"]),
            ''
        );

        $picture->save();

        return [];
    }
}