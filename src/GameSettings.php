<?php

namespace Choccybiccy\Werewolf;

/**
 * Class GameSettings
 * @package Choccybiccy\Werewolf
 */
class GameSettings
{

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * GameSettings constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get a game setting
     * @param string $key
     * @param mixed $default The default return if key not available
     * @return array
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->settings[$key];
        }
        return $default;
    }

    /**
     * Is the setting available?
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->settings);
    }

    /**
     * Return all the settings
     * @return array
     */
    public function all()
    {
        return $this->settings;
    }
}
