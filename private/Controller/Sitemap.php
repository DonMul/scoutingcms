<?php

namespace Controller;

use Lib\Core\Settings;
use Lib\Data\AlbumCategory;
use Lib\Data\Picture;

/**
 * Class Sitemap
 * @package Controller
 */
class Sitemap extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        header("Content-type: text/xml");

        return [
            'pages' => \Lib\Data\Page::getAll(),
            'groups' => \Lib\Data\Speltak::getAll(),
            'albumCategories' => AlbumCategory::getAll(),
            'albums' => \Lib\Data\Album::getAll(),
            'pictures' => Picture::getAll(),
            'agendaItems' => \Lib\Data\Agenda::getAll(),
            'downloads' => \Lib\Data\Download::getAll(),
            'newsItems' => \Lib\Data\News::getAll(),
            'host' => (Settings::getInstance()->get('ssl') == true ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']
        ];
    }
}