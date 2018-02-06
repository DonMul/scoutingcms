<?php

namespace Controller\Services\Admin\Page;

use Lib\Core\Translation;
use Lib\Data\Page;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Delete extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('pages.edit');

        $pageId = $this->getPostValue('pageId');
        $page = $this->getPageRepository()->getById($pageId);
        if (!($page instanceof Page)) {
            throw new \Exception(Translation::getInstance()->translate("error.page.notFound", ['id' => $pageId]));
        }

        $this->getPageRepository()->delete($page);

        return [
            'reload' => true,
        ];
    }
}
