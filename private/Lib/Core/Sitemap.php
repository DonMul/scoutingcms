<?php

namespace Lib\Core;

/**
 * Class Sitemap
 * @package Lib\Core
 * @author Joost Mul <scoutingcms@jmul.net>
 */
class Sitemap extends \Lib\Core\Singleton
{
    /**
     * @var array
     */
    private $sitemap;

    /**
     * @var array
     */
    private $sitemaps = [];

    /**
     * Sitemap constructor.
     */
    public function __construct()
    {
        $sitemaps = [];

        $dir = new \DirectoryIterator(CONFROOT . "/Sitemaps");
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $sitemaps[substr($fileinfo->getFileName(), 0, strlen($fileinfo->getFileName()) - 5)] =
                    \Symfony\Component\Yaml\Yaml::parse(
                        file_get_contents($fileinfo->getPathName())
                    );
            }
        }

        $this->sitemaps = $sitemaps;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getDataForUrl(string $url) : ?array
    {
        if ($this->sitemap) {
            return $this->getDataForUrlBySitemap($url, $this->sitemap);
        } else {
            $result = null;
            $foundSitemap = null;
            $foundLanguage = null;
            $translationLanguage = Translation::getInstance()->getLanguage();
            if (isset($this->sitemaps[$translationLanguage])) {
                $result = $this->getDataForUrlBySitemap($url, $this->sitemaps[$translationLanguage]);
                $foundSitemap = $this->sitemaps[$translationLanguage];
                $foundLanguage = $translationLanguage;
            } else {
                foreach ($this->sitemaps as $language => $sitemap) {
                    $result = $this->getDataForUrlBySitemap($url, $sitemap);
                    if ($result) {
                        $foundSitemap = $sitemap;
                        $foundLanguage = $language;
                        break;
                    }
                }
            }

            if ($result) {
                \Lib\Core\Translation::getInstance()->setLanguage($foundLanguage);
                $this->sitemap = $foundSitemap;

                return $result;
            }
        }

        return null;
    }

    /**
     * @param string $url
     * @param array $sitemap
     * @return array
     */
    public function getDataForUrlBySitemap(string $url, array $sitemap) : ?array
    {
        $url = strlen($url) > 1 ? rtrim($url, '/') : '/';

        if (isset($sitemap[$url])) {
            return $sitemap[$url];
        }

        $match = null;
        $routes = array_keys($sitemap);
        $explodedUrl = explode('/', $url);
        foreach ($routes as $route) {
            if (strpos($route, '{') === false) {
                continue;
            }

            $explodedRoute = explode('/', $route);
            if (count($explodedRoute) !== count($explodedUrl)) {
                continue;
            }

            $isMatch = true;
            foreach ($explodedRoute as $index => $routePart) {
                if (strpos($routePart, '{') === 0) {
                    continue;
                } elseif ($routePart !== $explodedUrl[$index]) {
                    $isMatch = false;
                }
            }

            if ($isMatch) {
                $match = $sitemap[$route];
                foreach ($explodedRoute as $index => $routePart) {
                    if (strpos($routePart, '{') === 0) {
                        $routePart = str_replace(['{', '}'], '', $routePart);
                        $_GET[$routePart] = $explodedUrl[$index];
                    }
                }
            }
        }

        return $match;
    }

    /**
     * @param string $hash
     * @return string
     */
    public function getLinkByHash(string $hash) : string
    {
        foreach ($this->sitemap as $link => $settings) {
            if ($settings['hash'] == $hash) {
                return $link;
            }
        }

        return $hash;
    }

    /**
     * @return array
     */
    public function getSitemaps() : array
    {
        return $this->sitemaps;
    }
}
