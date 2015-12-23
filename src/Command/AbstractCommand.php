<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Collection\PlayerCollection;
use Choccybiccy\Werewolf\Player;

/**
 * Class AbstractCommand
 * @package Choccybiccy\Werewolf\Command
 */
abstract class AbstractCommand implements CommandInterface
{

    /**
     * @var
     */
    protected $data = [];

    /**
     * @var Player
     */
    protected $player;

    /**
     * @var PlayerCollection
     */
    protected $players;

    /**
     * AbstractCommand constructor.
     * @param array $data
     * @param Player $player
     * @param PlayerCollection $players
     */
    public function __construct(array $data, Player $player, PlayerCollection $players)
    {
        $this->data = array_merge($this->data, $data);
        $this->player = $player;
        $this->players = $players;
    }
}
