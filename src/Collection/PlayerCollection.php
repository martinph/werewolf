<?php

namespace Choccybiccy\Werewolf\Collection;

use Choccybiccy\Werewolf\GameSettings;
use Choccybiccy\Werewolf\Player;
use Choccybiccy\Werewolf\PlayerFactory;
use Ratchet\ConnectionInterface;

/**
 * Class PlayerCollection
 * @package Choccybiccy\Werewolf\Collection
 */
class PlayerCollection extends \SplObjectStorage
{

    /**
     * @var array
     */
    protected $types = [
        Player::TYPE_VILLAGER,
        Player::TYPE_DOCTOR,
        Player::TYPE_SEER,
        Player::TYPE_WEREWOLF,
    ];

    /**
     * @var array
     */
    protected $players = [];

    /**
     * @var PlayerFactory
     */
    protected $playerFactory;

    /**
     * @var GameSettings
     */
    protected $settings;

    /**
     * PlayerCollection constructor.
     * @param PlayerFactory $playerFactory
     * @param GameSettings $settings
     */
    public function __construct(PlayerFactory $playerFactory, GameSettings $settings)
    {
        $this->playerFactory = $playerFactory;
        $this->settings = $settings;
    }

    /**
     * @param ConnectionInterface $connection
     * @param null $data
     */
    public function attach(ConnectionInterface $connection, $data = null)
    {
        parent::attach($connection, $data);
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function detach(ConnectionInterface $connection)
    {
        $this->removePlayerByConnection($connection);
        parent::detach($connection);
    }

    /**
     * Make players out of connections
     */
    public function makePlayers()
    {

        $connections = iterator_to_array($this, false);
        $nicknameSuffixes = range(1, $this->count());
        shuffle($nicknameSuffixes);
        shuffle($connections);

        $allowedWerewolfs = round($this->count()*$this->settings->get("villager_werewolf_ratio", 0.3));
        $allowedDoctors = $this->settings->get("doctors_count", 1);
        $allowedSeers = $this->settings->get("seers_count", 1);

        /** @var ConnectionInterface $connection */
        foreach ($connections as $connection) {
            if ($allowedWerewolfs > 0) {
                $type = Player::TYPE_WEREWOLF;
                $allowedWerewolfs--;
            } elseif ($allowedDoctors > 0) {
                $type = Player::TYPE_DOCTOR;
                $allowedDoctors--;
            } elseif ($allowedSeers > 0) {
                $type = Player::TYPE_SEER;
                $allowedSeers--;
            } else {
                $type = Player::TYPE_VILLAGER;
            }
            $nickname = $this->settings->get("villager_prefix", "Villager") . " " . array_pop($nicknameSuffixes);
            $player = $this->playerFactory->create(
                $connection,
                $type,
                $nickname
            );
            $this->players[spl_object_hash($connection)] = $player;
        }

        uasort($this->players, function (Player $a, Player $b) {
            return ($a->getNickname() < $b->getNickname()) ? -1 : 1;
        });

    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param string $hash
     * @return Player
     */
    public function getPlayer($hash)
    {
        return array_key_exists($hash, $this->players) ? $this->players[$hash] : null;
    }

    /**
     * @param ConnectionInterface $connection
     * @return null
     */
    public function getPlayerByConnection(ConnectionInterface $connection)
    {
        return $this->getPlayer(spl_object_hash($connection));
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function removePlayerByConnection(ConnectionInterface $connection)
    {
        $hash = spl_object_hash($connection);
        if (array_key_exists($hash, $this->players)) {
            unset($this->players[$hash]);
        }
    }

    /**
     * Get the player type counts
     * @return array
     */
    public function getTypeCounts()
    {
        $types = array_combine($this->types, array_fill(0, count($this->types), 0));
        /** @var Player $player */
        foreach ($this->players as $player) {
            $types[$player->getType()]++;
        }
        return $types;
    }

    /**
     * Get individual player type count
     * @param string $type
     * @return int
     */
    public function getTypeCount($type)
    {
        $counts = $this->getTypeCounts();
        return array_key_exists($type, $counts) ? $counts[$type] : 0;
    }
}
