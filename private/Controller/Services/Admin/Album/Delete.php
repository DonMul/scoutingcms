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
        $album = Album::getById($albumId);
        if (!($album instanceof Album)) {
            throw new \Exception(Translation::getInstance()->translate("error.album.notFound", ['id' => $albumId]));
        }

        $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');

        $album->delete();

        return [
            'reload' => true,
        ];
    }
}
