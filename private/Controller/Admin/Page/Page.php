<?php

namespace Controller\Admin\Page;

use Controller\Admin;
use Lib\Core\Translation;

/**
 * Class Page
 * @package Controller\Admin\Page
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Page extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('pages.edit');

        $page = $this->getPageRepository()->getById($this->getVariable('id', 0));
        if (!$page) {
            $page = new \Lib\Data\Page(null, Translation::getInstance()->translate('page.title'), "", "", "", false);
        }

        return [
            'page' => $page,
            'active' => 'page',
            'isNew' => $page->getId() == null,
        ];
    }
}
