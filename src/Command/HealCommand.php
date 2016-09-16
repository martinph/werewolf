<?php

namespace Choccybiccy\Werewolf\Command;

use Choccybiccy\Werewolf\Player;

/**
 * Class HealCommand.
 */
class HealCommand extends AbstractCommand
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
        if ($this->player->getType() !== Player::TYPE_DOCTOR) {
            return $this->makeResponse([
                'success' => false,
                'message' => 'Cannot heal, you are not a doctor',
            ]);
        }
        try {
            $target = $this->getTargetPlayer();
            try {
                $target->revive();

                return $this->makeResponse([
                    'success' => true,
                    'message' => $target->getNickname().' healed',
                    'target' => $target,
                ]);
            } catch (PlayerLivingException $e) {
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
