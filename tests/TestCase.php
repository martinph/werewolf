<?php

namespace Choccybiccy\Werewolf;

/**
 * Class TestCase
 * @package Choccybiccy\Werewolf
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @param null $methods
     * @param \null $connection
     * @param null $type
     * @param null $nickname
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockPlayer($methods = null, $connection = null, $type = null, $nickname = null)
    {
        return $this->getMock('Choccybiccy\Werewolf\Player', $methods, [
            $connection ?: $this->getMock('Ratchet\ConnectionInterface'),
            $type ?: Player::TYPE_WEREWOLF,
            $nickname ?: "Villager 1",
        ]);
    }

    /**
     * @param array $methods
     * @param int $mockConnections
     * @param \PHPUnit_Framework_MockObject_MockObject|null $settings
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockPlayerCollection($methods = null, $mockConnections = 0, $settings = null)
    {
        $collection = $this->getMockBuilder('Choccybiccy\Werewolf\Collection\PlayerCollection')
            ->setConstructorArgs(
                [
                    $this->getMock('Choccybiccy\Werewolf\PlayerFactory', null),
                    $settings ?: $this->getMockGameSettings(),
                ]
            )
            ->setMethods($methods)
            ->getMock();
        if ($mockConnections > 0) {
            for ($i=1; $i<=$mockConnections; $i++) {
                $collection->attach($this->getMock('Ratchet\ConnectionInterface'));
            }
        }
        return $collection;
    }

    /**
     * @param array $settings
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockGameSettings(array $settings = [])
    {
        return $this->getMock('Choccybiccy\Werewolf\GameSettings', null, [$settings]);
    }
}
