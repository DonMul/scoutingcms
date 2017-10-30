<?php

namespace Controller\Services\Admin\Page;

use Lib\Core\Translation;
use Lib\Data\Page;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Delete extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $pageId = $this->getPostValue('pageId');
        $page = Page::getById($pageId);
        if (!($page instanceof Page)) {
            throw new \Exception(Translation::getInstance()->translate("error.page.notFound", ['id' => $pageId]));
        }

        $page->delete();

        return [
            'reload' => true,
        ];
    }
}