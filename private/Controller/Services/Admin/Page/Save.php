<?php

namespace Controller\Services\Admin\Page;

use Lib\Core\Translation;
use Lib\Core\Util;
use Lib\Data\Page;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Save extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('pages.edit');

        $pageId = intval($this->getPostValue('pageId'));
        $page = $this->getPageRepository()->getById($pageId);
        if (!($page instanceof Page) && intval($pageId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.page.notFound", ['id' => $pageId]));
        }

        $slug = $this->getPostValue('slug');
        if (empty($slug)) {
            $slug = Util::slugify($this->getPostValue('title'));
        }

        if ($page) {
            $page->setTitle($this->getPostValue('title'));

            $page->setSlug($slug);
            $page->setContent($this->getPostValue('content'));
            $page->setIsHomepage(isset($_POST['isHomepage']));
        } else {
            $page = new Page(
                null,
                $this->getPostValue('title'),
                $slug,
                $this->getPostValue('content'),
                '',
                isset($_POST['isHomepage'])
            );
        }

        $this->getPageRepository()->save($page);

        return [
            'redirect' => Translation::getInstance()->translateLink("adminPages")
        ];
    }
}
