<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Collection\PlayerCollection;
use Choccybiccy\Werewolf\Player;
use Choccybiccy\Werewolf\TestCase;

/**
 * Class CommandTestCase
 * @package Choccybiccy\Werewolf\Command
 */
class CommandTestCase extends TestCase
{

    /**
     * @param array|null $methods
     * @param array $data
     * @param Player|null $player
     * @param PlayerCollection|null $collection
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCommand($methods = null, array $data = [], $player = null, $collection = null)
    {
        $command = preg_replace("/Test\$/", "", get_class($this));
        return $this->getMockBuilder($command)
            ->setConstructorArgs([
                $data ?: [],
                $player ?: $this->getMockPlayer(),
                $collection ?: $this->getMockPlayerCollection(),
            ])
            ->setMethods($methods)
            ->getMock();
    }
}
