<?php

namespace Controller;

use Lib\Core\Settings;

/**
 * Class Sitemap
 * @package Controller
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Sitemap extends \Lib\Core\BaseController
{
    /**
     * @return array
     */
    public function getArray()
    {
        header("Content-type: text/xml");

        return [
            'pages' => $this->getPageRepository()->getAll(),
            'groups' => $this->getSpeltakRepository()->getAll(),
            'albumCategories' => $this->getAlbumCategoryRepository()->getAll(),
            'albums' => $this->getAlbumRepository()->getAll(),
            'pictures' => $this->getPictureRepository()->getAll(),
            'agendaItems' => $this->getAgendaRepository()->getAll(),
            'downloads' => $this->getDownloadRepository()->getAll(),
            'newsItems' => $this->getNewsRepository()->getAll(),
            'host' => (Settings::getInstance()->get('ssl') == true ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']
        ];
    }
}
