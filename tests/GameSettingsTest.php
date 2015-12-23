<?php

namespace Choccybiccy\Werewolf;

/**
 * Class GameSettingsTest
 * @package Choccybiccy\Werewolf
 */
class GameSettingsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test GameSettings
     */
    public function testGameSettings()
    {
        $settings = [
            "setting1" => "value1",
            "setting2" => "value2",
        ];
        $gameSettings = new GameSettings($settings);
        $this->assertEquals($settings['setting1'], $gameSettings->get("setting1"));
        $this->assertTrue($gameSettings->has("setting1"));
        $this->assertFalse($gameSettings->has("setting3"));
        $this->assertEquals($settings, $gameSettings->all());
    }
}
