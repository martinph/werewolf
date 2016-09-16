<?php

namespace Choccybiccy\Werewolf;

use Choccybiccy\Werewolf\Collection\PlayerCollection;
use Choccybiccy\Werewolf\Exception\MalformedDataException;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Class Game.
 */
class Game implements MessageComponentInterface
{
    /**
     * @var GameSettings
     */
    protected $settings;

    /**
     * @var PlayerCollection
     */
    protected $players;

    /**
     * @var PlayerFactory
     */
    protected $playerFactory;

    /**
     * @var CommandHandler
     */
    protected $commandHandler;

    /**
     * Application constructor.
     *
     * @param GameSettings     $settings
     * @param PlayerCollection $players
     * @param PlayerFactory    $playerFactory
     * @param CommandHandler   $commandHandler
     */
    public function __construct(
        GameSettings $settings,
        PlayerCollection $players,
        PlayerFactory $playerFactory,
        CommandHandler $commandHandler
    ) {
        $this->settings = $settings;
        $this->commandHandler = $commandHandler;
        $this->players = $players;
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
    }

    /**
     * @param ConnectionInterface $from
     * @param string              $message
     */
    public function onMessage(ConnectionInterface $from, $message)
    {
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    /**
     * Decode JSON data.
     *
     * @param string $string
     *
     * @return array
     *
     * @throws MalformedDataException
     */
    protected function decode($string)
    {
        $decoded = json_decode($string, true);
        if ($decoded === null) {
            throw new MalformedDataException('The message data cannot be decoded');
        }

        return $decoded;
    }
}
