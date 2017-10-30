<?php

namespace Lib\Core;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Settings
 * @package Lib\Core
 * @author  Joost Mul <jmul@posd.io>
 */
class Settings extends \Lib\Core\Singleton
{
    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @constructor
     */
    public function __construct()
    {
        $this->settings = Yaml::parse(file_get_contents(CONFROOT . 'settings.yaml'));
    }

    /**
     * Returns the value of the setting with the given name. This name can be a recursive pointer in the shape on an
     * associative array
     *
     * @param string|string[] $name
     * @param mixed           $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return \Lib\Core\Util::arrayGet($this->settings, $name, $default);
    }

    /**
     * Return all settings
     *
     * @return array
     */
    public function getAll()
    {
        return $this->settings;
    }

    /**
     * Recursively builds a string bases on the settings. This string is the PHP representation of the innards of the
     * settings array
     *
     * @param array $settings
     * @param int   $depth
     * @return string
     */
    public function getSettingsString($settings, $depth = 1)
    {
        $string = "";

        foreach ($settings as $name => $value) {
            $string .= str_repeat("\t", $depth) . "'$name' => ";

            if (is_array($value)) {
                $string .= "[" . PHP_EOL;
                $string .= $this->getSettingsString($value, $depth + 1);
                $string .= str_repeat("\t", $depth) . "],";
            } else {
                $string .= "'$value',";
            }
            $string .= PHP_EOL;
        }

        return $string;
    }
} 
