<?php

/**
 * Class SitemapTest
 */
class SitemapTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function testGetDataForUrl()
    {
        $sitemap = new \Lib\Core\Sitemap();

        $this->assertEquals($sitemap->getDataForUrl('/'), [
            'controller' => '\Controller\Index',
            'hash' => 'index',
        ]);

        $this->assertEquals($sitemap->getDataForUrl('/'), [
            'controller' => '\Controller\Index',
            'hash' => 'index',
        ]);

        $this->assertEquals($sitemap->getDataForUrl('/nonesiting-page-slug'), [
            'controller' => '\Controller\Page',
            'hash' => 'page',
        ]);


    }

    /**
     *
     */
    public function testGetDataForUrlDataNotFound()
    {
        $sitemap = new \Lib\Core\Sitemap();
        $this->assertEquals($sitemap->getDataForUrl('/non/existing/page'), null);
    }

    /**
     *
     */
    public function testGetLinkByHash()
    {
        $sitemap = new \Lib\Core\Sitemap();
        $url = '/';
        $data = $sitemap->getDataForUrl($url);
        $this->assertEquals($sitemap->getLinkByHash($data['hash']), $url);

        $nonExistingHash = "NONEXISTINGHASH!";
        $this->assertEquals($sitemap->getLinkByHash($nonExistingHash), $nonExistingHash);
    }

    /**
     *
     */
    public function testGetSitemaps()
    {
        $sitemap = new \Lib\Core\Sitemap();
        $this->assertEquals(array_keys($sitemap->getSitemaps()), ['en', 'nl']);
    }
}
