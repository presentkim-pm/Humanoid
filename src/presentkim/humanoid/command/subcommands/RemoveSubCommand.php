<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\PoolCommand, HumanoidMain as Plugin, command\SubCommand, task\PlayerTask, task\RemoveHumanoidTask, util\Translation
};

class RemoveSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'remove');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            PlayerTask::registerTask(new RemoveHumanoidTask($sender));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}