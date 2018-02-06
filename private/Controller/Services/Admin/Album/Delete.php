<?php

namespace Controller\Services\Admin\Album;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Album;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Delete extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $albumId = $this->getPostValue('albumId');
        $album = $this->getAlbumRepository()->getById($albumId);
        if (!($album instanceof Album)) {
            throw new \Exception(Translation::getInstance()->translate("error.album.notFound", ['id' => $albumId]));
        }

        $this->ensurePermission('album.' . $this->getAlbumCategoryRepository()->getById($album->getCategory())->getName() . '.edit');

        $this->getAlbumRepository()->delete($album);

        return [
            'reload' => true,
        ];
    }
}
