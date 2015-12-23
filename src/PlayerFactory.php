<?php

namespace Choccybiccy\Werewolf;

use Ratchet\ConnectionInterface;

/**
 * Class PlayerFactory
 * @package Choccybiccy\Werewolf
 */
class PlayerFactory
{

    /**
     * @param ConnectionInterface $connection
     * @param string $type
     * @param string $nickname
     * @return Player
     */
    public function create(ConnectionInterface $connection, $type, $nickname)
    {
        return new Player($connection, $type, $nickname);
    }
}
