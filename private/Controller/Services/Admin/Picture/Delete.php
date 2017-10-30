<?php

namespace Controller\Services\Admin\Picture;

use Controller\Services\Admin;
use Lib\Core\Translation;
use Lib\Data\Album;
use Lib\Data\Picture;

/**
 * Class Delete
 * @package Controller\Services\Admin\Picture
 */
class Delete extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $pictureId = $this->getPostValue('pictureId');
        $picture = Picture::getById($pictureId);
        if (!$picture) {
            throw new \Exception(Translation::getInstance()->translate('error.picture.notFOund'));
        }

        $album = Album::getById($picture->getAlbumId());
        $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');

        $picture->delete();

        return [
            'reload' => true,
        ];
    }
}