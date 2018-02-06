<?php

namespace Controller\Services\Admin\News;
use Lib\Core\Translation;
use Lib\Data\News;

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
        $this->ensurePermission('news.edit');

        $newsId = $this->getPostValue('itemId');
        $news = $this->getNewsRepository()->getById($newsId);
        if (!($news instanceof News)) {
            throw new \Exception(Translation::getInstance()->translate("error.news.notFound", ['id' => $newsId]));
        }

        $this->getNewsRepository()->delete($news);

        return [
            'reload' => true,
        ];
    }
}
