<?php

namespace Lib\Core;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Translation
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Translation extends \Lib\Core\Singleton
{
    /**
     * Whether or not the translations have been loaded
     *
     * @var bool
     */
    private $loaded = false;

    /**
     * Contains the loaded translations
     *
     * @var array
     */
    private $translations = [];

    /**
     * @var array
     */
    private $urls = [];

    /**
     * @var string
     */
    private $lang;

    /**
     * Makes sure the right translation is loaded
     */
    protected function ensureLoaded()
    {
        if ($this->loaded === true) {
            return;
        }

        $lang = $this->getLanguage();

        $this->translations = Yaml::parse(file_get_contents(CONFROOT . "Translations/default.yaml"));
        $this->translations = array_merge(Yaml::parse(file_get_contents(CONFROOT . "Translations/{$lang}.yaml")), $this->translations);
    }

    /**
     * Returns the translation with the given key. If it contains any placeholders, it should replace them with the
     * given replacements.
     *
     * @param string $key
     * @param array  $replacements
     * @return string
     */
    public function translate($key, $replacements = [])
    {
        $this->ensureLoaded();
        $string = \Lib\Core\Util::arrayGet($this->translations, [$key], $key);

        foreach ($replacements as $key => $value) {
            $string = str_replace("{\$$key}", $value, $string);
        }

        return $string;
    }

    /**
     * Returns all enabled languages
     *
     * @return array
     */
    public function getAllLanguages()
    {
        $languages = [];

        $dir = new \DirectoryIterator(CONFROOT . "/Translations");
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && $fileinfo->getFileName() !== 'default.yaml') {
                $languages[] = substr($fileinfo->getFileName(), 0, strlen($fileinfo->getFileName()) - 5);
            }
        }

        return $languages;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        if (!isset($this->lang)) {
            $lang = Settings::getInstance()->get('defaultLanguage');

            if (isset($_COOKIE['language'])) {
                $lang = $_COOKIE['language'];
            }

            if (isset($_GET['language'])) {
                $lang = $_GET['language'];
                if (isset($_COOKIE['language'])) {
                    unset($_COOKIE['language']);
                }
            };

            $this->lang = $lang;
            setcookie('language', $lang);
        }

        return $this->lang;
    }

    /**
     * @param $language
     */
    public function setLanguage($language)
    {
        $this->lang = $language;
    }

    /**
     * @param string $linkHash
     * @param array  $params
     * @return string
     */
    public function translateLink($linkHash, $params = [])
    {
        $url = '/' . ltrim(\Lib\Core\Sitemap::getInstance()->getLinkByHash($linkHash, $params), '/');
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        return $url;
    }
}
