<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Exception\PlayerLivingException;
use Choccybiccy\Werewolf\Exception\PlayerNotFoundException;

/**
 * Class KillCommand
 * @package Choccybiccy\Werewolf\Command
 */
class KillCommand extends AbstractCommand
{

    /**
     * @var array
     */
    protected $data = [
        "target" => null,
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        try {
            $target = $this->getTargetPlayer();
            try {
                $target->kill();
                return $this->makeResponse([
                    "success" => true,
                    "message" => $target->getNickname() . " killed",
                    "target" => $target,
                ]);
            } catch (PlayerLivingException $e) {
                return $this->makeResponse([
                    "success" => false,
                    "message" => $e->getMessage(),
                    "target" => $target,
                ]);
            }
        } catch (\Exception $e) {
            return $this->makeResponse([
                "success" => false,
                "message" => $e->getMessage(),
            ]);
        }
    }
}
