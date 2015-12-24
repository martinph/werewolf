<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Player;

/**
 * Class RevealCommandTest
 * @package Choccybiccy\Werewolf\Command
 */
class RevealCommandTest extends CommandTestCase
{

    /**
     * Test run() returns a random werewolf
     */
    public function testRun()
    {
        $collection = $this->getMockPlayerCollection(null, 6);
        $collection->makePlayers();

        /** @var RevealCommand $command */
        $command = $this->getMockCommand(null, [], null, $collection);
        $response = $command->run();
        $this->assertTrue($response->isSuccess());
        $player = $response->get("player");
        $this->assertInstanceOf('Choccybiccy\Werewolf\Player', $player);
        $this->assertEquals(Player::TYPE_WEREWOLF, $player->getType());
    }

    /**
     * Test run() returns an error response when no werewolfs found
     */
    public function testRunReturnsErrorResponseWhenNoPlayerFound()
    {
        $collection = $this->getMockPlayerCollection();
        $command = $this->getMockCommand(null, [], null, $collection);
        $response = $command->run();
        $this->assertFalse($response->isSuccess());
    }

    /**
     * Test all() reveals all werewolfs
     */
    public function testAll()
    {
        $collection = $this->getMockPlayerCollection(null, 4);
        $collection->makePlayers();

        /** @var RevealCommand $command */
        $command = $this->getMockCommand(null, [], null, $collection);
        $response = $command->all();
        $this->assertTrue($response->isSuccess());
        foreach ($response->get("players") as $player) {
            $this->assertEquals(Player::TYPE_WEREWOLF, $player->getType());
        }
    }

    public function testAllReturnsErrorResponseWhenNoPlayersFound()
    {
        $collection = $this->getMockPlayerCollection();
        $command = $this->getMockCommand(null, [], null, $collection);
        $response = $command->all();
        $this->assertFalse($response->isSuccess());
    }
}
