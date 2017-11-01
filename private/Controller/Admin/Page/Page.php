<?php

namespace Controller\Admin\Page;

use Controller\Admin;

/**
 * Class Page
 * @package Controller\Admin\Page
 */
class Page extends Admin
{
    /**
     * @return array
     */
    public function getArray()
    {
        $this->ensurePermission('pages.edit');

        $page = \Lib\Data\Page::getById($_GET['id']);
        if (!$page) {
            $page = new \Lib\Data\Page(null, "New Page", "", "", "", false);
        }

        return [
            'page' => $page,
            'active' => 'page'
        ];
    }
}