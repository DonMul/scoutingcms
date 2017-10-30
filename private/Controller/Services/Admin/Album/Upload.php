<?php

namespace Controller\Services\Admin\Album;

use Lib\Core\BaseController;
use Lib\Data\Album;
use Lib\Data\AlbumCategory;
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
        $album = Album::getById($_GET['id']);
        if (!$album) {
            return [];
        }

        $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');

        $category = AlbumCategory::getById($album->getCategory());
        $targetDir = ROOT . "../public/upload/" . $category->getName() . "/" . md5($album->getId()) . '/';

        if (!is_dir(ROOT . "../public/upload/" . $category->getName())) {
            mkdir(ROOT . "../public/upload/" . $category->getName());
        }

        if (!is_dir(ROOT . "../public/upload/" . $category->getName() . "/" . md5($album->getId()))) {
            mkdir(ROOT . "../public/upload/" . $category->getName() . "/" . md5($album->getId()));
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