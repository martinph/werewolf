<?php

namespace Choccybiccy\Werewolf\Command;

/**
 * Class KillCommand
 * @package Choccybiccy\Werewolf\Command
 */
class KillCommand extends AbstractCommand
{

    /**
     * @var array
     */
    protected $options = [
        "target" => null,
    ];
}
