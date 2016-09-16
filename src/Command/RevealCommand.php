<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Player;

/**
 * Class RevealCommand.
 */
class RevealCommand extends AbstractCommand
{
    /**
     * @var array
     */
    protected $data = [
        'type' => Player::TYPE_WEREWOLF,
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $type = $this->data['type'];
        // Return a random werewolf
        $hash = array_rand($this->players->getPlayersByType($type));
        if (!$hash) {
            return $this->makeResponse([
                'success' => false,
                'message' => "No players found matching type '$type'",
            ]);
        }
        $player = $this->players->getPlayer($hash);

        return $this->makeResponse([
            'success' => true,
            'message' => $player->getNickname()." is a $type",
            'player' => $player,
        ]);
    }

    /**
     * Reveal all players.
     *
     * @return Response
     */
    public function all()
    {
        $type = $this->data['type'];
        $players = $this->players->getPlayersByType($type);
        if (!count($players)) {
            return $this->makeResponse([
                'success' => false,
                'message' => "No players found matching type '$type'",
            ]);
        }
        $nicknames = [];
        foreach ($players as $player) {
            $nicknames[] = $player->getNickname();
        }
        $lastNickname = array_pop($nicknames);
        $nicknames = count($nicknames) ? implode(', ', $nicknames)." and $lastNickname" : $lastNickname;
        $message = $nicknames.' are '.$type.'s';
        if (count($players) == 1) {
            $message = $nicknames.' is a '.$type;
        }

        return $this->makeResponse([
            'success' => true,
            'messages' => $message,
            'players' => $players,
        ]);
    }
}
