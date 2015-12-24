<?php

namespace Choccybiccy\Werewolf\Collection;

use Choccybiccy\Werewolf\Player;
use Choccybiccy\Werewolf\TestCase;

/**
 * Class PlayerCollectionTest
 * @package Choccybiccy\Werewolf\Collection
 */
class PlayerCollectionTest extends TestCase
{

    /**
     * Test makePlayers makes players out of connections
     */
    public function testMakePlayers()
    {
        $collection = $this->getMockPlayerCollection(null, 6, $this->getMockGameSettings([
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
        $collection = $this->getMockPlayerCollection(null, 1);
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
        $collection = $this->getMockPlayerCollection(["removePlayerByConnection"], 1);
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
        $collection = $this->getMockPlayerCollection(null, 1, $this->getMockGameSettings([
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
        $collection = $this->getMockPlayerCollection(null, 1, $this->getMockGameSettings([
            "villager_werewolf_ratio" => 1,
        ]));
        $collection->makePlayers();
        $collection->rewind();
        $connection = $collection->current();
        $this->assertEquals($connection, $collection->getPlayer(spl_object_hash($connection))->getConnection());
    }

    /**
     * Test getPlayersByType returns players by a given type
     */
    public function testGetPlayersByType()
    {
        $collection = $this->getMockPlayerCollection(null, 7);
        $collection->makePlayers();
        $types = array_keys($collection->getTypeCounts());
        foreach ($types as $type) {
            $players = $collection->getPlayersByType($type);
            foreach ($players as $player) {
                $this->assertEquals($type, $player->getType());
            }
        }
    }
}
