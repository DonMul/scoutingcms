<?php

namespace Controller\Services\Admin\Album;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Album;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Save extends \Controller\Services\Admin
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getArray()
    {
        $albumId = $this->getPostValue('albumId');
        $album = Album::getById($albumId);
        if (!($album instanceof Album) && intval($albumId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.album.notFound", ['id' => $albumId]));
        }

        $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');

        if ($album) {
            $album->setName($this->getPostValue('name'));
            $album->setDescription($this->getPostValue('description'));
            $album->setCategory($this->getPostValue('category'));
        } else {
            $album = new Album(
                null,
                $this->getPostValue('name'),
                Util::slugify($this->getPostValue('name')),
                $this->getPostValue('description'),
                $this->getPostValue('category'),
                ''
            );
        }

        $album->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminAlbums"),
        ];
    }
}