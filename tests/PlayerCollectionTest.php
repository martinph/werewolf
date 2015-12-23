<?php

namespace Choccybiccy\Werewolf\Collection;

use Choccybiccy\Werewolf\Player;

/**
 * Class PlayerCollectionTest
 * @package Choccybiccy\Werewolf\Collection
 */
class PlayerCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test makePlayers makes players out of connections
     */
    public function testMakePlayers()
    {
        $collection = $this->getMockCollection(null, 6, $this->getMockGameSettings([
            "villager_werewolf_ratio" => 0.3,
            "doctors_count" => 1,
            "seers_count" => 1,
        ]));
        $collection->makePlayers();
        $this->assertEquals(6, $collection->count());
        $this->assertEquals(1, $collection->getTypeCount(Player::TYPE_DOCTOR));
        $this->assertEquals(1, $collection->getTypeCount(Player::TYPE_SEER));
        $this->assertEquals(2, $collection->getTypeCount(Player::TYPE_WEREWOLF));
        $this->assertEquals(2, $collection->getTypeCount(Player::TYPE_VILLAGER));
    }

    /**
     * Test PlayerCollection::detach(...) removes player from the players list
     */
    public function testRemovePlayerByConnection()
    {
        /** @var PlayerCollection $collection */
        $collection = $this->getMockCollection(null, 1);
        $collection->makePlayers();
        $collection->rewind();

        $connection = $collection->current();
        $player = $collection->getPlayerByConnection($connection);
        $this->assertInstanceOf('Choccybiccy\Werewolf\Player', $player);

        $collection->removePlayerByConnection($connection);
        $this->assertNull($collection->getPlayerByConnection($connection));

    }

    /**
     * Test detach calls removePlayerByConnection(ConnectionInterface)
     */
    public function testDetachCallsRemovePlayerByConnection()
    {
        $collection = $this->getMockCollection(["removePlayerByConnection"], 1);
        $collection->rewind();
        $connection = $collection->current();
        $collection->expects($this->once())
            ->method("removePlayerByConnection")
            ->with($connection);
        $collection->detach($connection);
    }

    /**
     * Test getPlayers returns players
     */
    public function testGetPlayers()
    {
        $collection = $this->getMockCollection(null, 1, $this->getMockGameSettings([
            "villager_werewolf_ratio" => 1,
        ]));
        $collection->makePlayers();
        $players = $collection->getPlayers();
        $this->assertEquals(Player::TYPE_WEREWOLF, current($players)->getType());
    }

    /**
     * Test getPlayer returns player
     */
    public function testGetPlayer()
    {
        $collection = $this->getMockCollection(null, 1, $this->getMockGameSettings([
            "villager_werewolf_ratio" => 1,
        ]));
        $collection->makePlayers();
        $collection->rewind();
        $connection = $collection->current();
        $this->assertEquals($connection, $collection->getPlayer(spl_object_hash($connection))->getConnection());
    }

    /**
     * @param array $methods
     * @param int $mockConnections
     * @param \PHPUnit_Framework_MockObject_MockObject|null $settings
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCollection($methods = null, $mockConnections = 0, $settings = null)
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
