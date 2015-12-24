<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Collection\PlayerCollection;
use Choccybiccy\Werewolf\Exception\PlayerNotFoundException;
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

    /**
     * Find a target player by their hash
     * @return Player
     * @throws PlayerNotFoundException
     */
    protected function getTargetPlayer()
    {
        $target = $this->players->getPlayer($this->data['target']);
        if (!$target) {
            throw new PlayerNotFoundException("Target player not found");
        }
        return $target;
    }

    /**
     * @param array $data
     * @return Response
     */
    protected function makeResponse(array $data)
    {
        return new Response($data, $this);
    }
}
