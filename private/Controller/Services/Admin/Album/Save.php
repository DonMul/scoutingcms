<?php

namespace Controller\Services\Admin\Album;

use Lib\Core\Imager;
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

        if ($album) {
            $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');

            $album->setName($this->getPostValue('name'));
            $album->setDescription($this->getPostValue('description'));
            $album->setCategory($this->getPostValue('category'));
            $album->setPrivate(isset($_POST['private']));
        } else {
            $album = new Album(
                null,
                $this->getPostValue('name'),
                Util::slugify($this->getPostValue('name')),
                $this->getPostValue('description'),
                $this->getPostValue('category'),
                '',
                isset($_POST['private'])
            );

            $this->ensurePermission('album.' . $album->getCategoryObject()->getName() . '.edit');
        }

        if (!empty($_FILES['thumbnail']['name'])) {
            $targetName = $_SERVER["DOCUMENT_ROOT"] . 'public/upload/' . $album->getCategoryObject()->getName() . '/' . $_FILES["thumbnail"]["name"];

            $imager = new Imager();
            $imager->uploadImage($_FILES['thumbnail']['tmp_name'], $targetName);
            $imager->resizeImage($targetName, 400, 400);

            $album->setThumbnail($_FILES["thumbnail"]["name"]);
        }

        $album->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminAlbums"),
        ];
    }
}