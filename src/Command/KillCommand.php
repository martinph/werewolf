<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Exception\PlayerDeadException;
use Choccybiccy\Werewolf\Player;

/**
 * Class KillCommand.
 */
class KillCommand extends AbstractCommand
{
    /**
     * @var array
     */
    protected $data = [
        'target' => null,
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->player->getType() !== Player::TYPE_WEREWOLF) {
            return $this->makeResponse([
                'success' => false,
                'message' => 'Cannot kill, you are not a werewolf',
            ]);
        }
        try {
            $target = $this->getTargetPlayer();
            try {
                $target->kill();

                return $this->makeResponse([
                    'success' => true,
                    'message' => $target->getNickname().' killed',
                    'target' => $target,
                ]);
            } catch (PlayerDeadException $e) {
                return $this->makeResponse([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'target' => $target,
                ]);
            }
        } catch (\Exception $e) {
            return $this->makeResponse([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
