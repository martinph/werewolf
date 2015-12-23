<?php

namespace Choccybiccy\Werewolf;

use Choccybiccy\Werewolf\Exception\MalformedDataException;
use Choccybiccy\Werewolf\Exception\UnknownCommandException;
use Ratchet\ConnectionInterface;

/**
 * Class CommandHandler
 * @package Choccybiccy\Werewolf
 */
class CommandHandler
{

    const COMMAND_CHAT = "chat";
    const COMMAND_HEAL = "heal";
    const COMMAND_KILL = "kill";
    const COMMAND_REVEAL = "reveal";

    const KEY_COMMAND = "command";

    /**
     * @var array
     */
    protected $commands = [
        self::COMMAND_CHAT => 'Choccybiccy\Werewolf\Command\ChatCommand',
        self::COMMAND_HEAL => 'Choccybiccy\Werewolf\Command\HealCommand',
        self::COMMAND_KILL => 'Choccybiccy\Werewolf\Command\KillCommand',
        self::COMMAND_REVEAL => 'Choccybiccy\Werewolf\Command\RevealCommand',
    ];

    /**
     * @param array $data
     * @param ConnectionInterface $connection
     * @throws MalformedDataException
     * @throws UnknownCommandException
     */
    public function handle(array $data, ConnectionInterface $connection)
    {
        if (!array_key_exists(self::KEY_COMMAND, $data)) {
            throw new MalformedDataException("Data is missing the " . self::KEY_COMMAND . " attribute");
        }

        $command = $data[self::KEY_COMMAND];

        if (!array_key_exists($command, $this->commands)) {
            throw new UnknownCommandException("The command '$command' is not recognised'");
        }

        $command = new $this->commands[$command]($data, $connection);
        return $command;
    }
}