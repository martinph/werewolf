<?php

namespace Choccybiccy\Werewolf;

use Choccybiccy\Werewolf\Exception\PlayerDeadException;
use Choccybiccy\Werewolf\Exception\PlayerLivingException;
use Ratchet\ConnectionInterface;

/**
 * Class Player.
 */
class Player
{
    const TYPE_WEREWOLF = 'werewolf';
    const TYPE_VILLAGER = 'villager';
    const TYPE_SEER = 'seer';
    const TYPE_DOCTOR = 'doctor';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $nickname;

    /**
     * @var bool
     */
    protected $alive = true;

    /**
     * AbstractPlayer constructor.
     *
     * @param ConnectionInterface $connection
     * @param string              $type
     * @param string              $nickname
     */
    public function __construct(ConnectionInterface $connection, $type, $nickname)
    {
        $this->connection = $connection;
        $this->type = $type;
        $this->nickname = $nickname;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Kill the player.
     */
    public function kill()
    {
        if (!$this->isAlive()) {
            throw new PlayerDeadException('Cannot kill player, player already dead');
        }
        $this->alive = false;
    }

    /**
     * Revive the player.
     */
    public function revive()
    {
        if ($this->isAlive()) {
            throw new PlayerLivingException('Cannot revive player, player is already alive');
        }
        $this->alive = true;
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return $this->alive;
    }
}
