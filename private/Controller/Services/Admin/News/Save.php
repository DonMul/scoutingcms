<?php

namespace Controller\Services\Admin\News;
use Lib\Core\Translation;
use Lib\Data\News;

/**
 * Class Login
 * @package Controller\Services\User
 * @author Joost Mul
 */
class Save extends \Controller\Services\Admin
{
    /**
     * @throws \Exception
     */
    public function getArray()
    {
        $this->ensurePermission('news.edit');

        $newsId = $this->getPostValue('newsId');
        $news = News::getById($newsId);
        if (!($news instanceof News) && intval($newsId) > 0) {
            throw new \Exception(Translation::getInstance()->translate("error.news.notFound", ['id' => $newsId]));
        }

        if ($news) {
            $news->setTitle($this->getPostValue('title'));
            $news->setStatus($this->getPostValue('status'));
            $news->setContent($this->getPostValue('content'));
        } else {
            $news = new News(
                null,
                $this->getPostValue('title'),
                $this->getPostValue('content'),
                date('Y-m-d H:i:s'),
                $this->getPostValue('status')
            );
        }

        $news->save();

        return [
            'redirect' => Translation::getInstance()->translateLink("adminNews")
        ];
    }
}