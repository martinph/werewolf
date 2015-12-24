<?php

namespace Choccybiccy\Werewolf;

/**
 * Class PlayerTest
 * @package Choccybiccy\Werewolf
 */
class PlayerTest extends TestCase
{

    /**
     * Test getters
     */
    public function testGetters()
    {
        $connection = $this->getMock('Ratchet\ConnectionInterface');
        $type = Player::TYPE_WEREWOLF;
        $nickname = "Villager 1";
        $player = new Player($connection, $type, $nickname);
        $this->assertEquals($connection, $player->getConnection());
        $this->assertEquals($type, $player->getType());
        $this->assertEquals($nickname, $player->getNickname());
    }

    /**
     * Test kill and revive player
     */
    public function testKillRevive()
    {
        $player = $this->getMockPlayer();
        $this->assertTrue($player->isAlive());
        $player->kill();
        $this->assertFalse($player->isAlive());
        $player->revive();
        $this->assertTrue($player->isAlive());
    }

    /**
     * Test kill throws an exception when the player is already dead
     */
    public function testKillThrowsExceptionWhenDead()
    {
        $player = $this->getMockPlayer(["isAlive"]);
        $player->expects($this->once())
            ->method("isAlive")
            ->willReturn(false);
        $this->setExpectedException('Choccybiccy\Werewolf\Exception\PlayerLivingException');
        $player->kill();
    }

    /**
     * Test revive throws an exception when the player is already alive
     */
    public function testReviveThrowsExceptionWhenAlive()
    {
        $player = $this->getMockPlayer(["isAlive"]);
        $player->expects($this->once())
            ->method("isAlive")
            ->willReturn(true);
        $this->setExpectedException('Choccybiccy\Werewolf\Exception\PlayerLivingException');
        $player->revive();
    }
}
