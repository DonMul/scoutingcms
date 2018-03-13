<?php

namespace Controller\Services\Admin\Picture;

use Controller\Services\Admin;
use Lib\Core\Translation;

/**
 * Class Delete
 * @package Controller\Services\Admin\Picture
 */
final class Delete extends Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $pictureId = $this->getPostValue('pictureId');
        $picture = $this->getPictureRepository()->getById($pictureId);
        if (!$picture) {
            throw new \Exception(Translation::getInstance()->translate('error.picture.notFOund'));
        }

        $album = $this->getAlbumRepository()->getById($picture->getAlbumId());
        $this->ensurePermission('album.' . $this->getAlbumCategoryRepository()->getById($album->getCategory())->getName() . '.edit');

        $this->getPictureRepository()->delete($picture);

        return [
            'reload' => true,
        ];
    }
}
