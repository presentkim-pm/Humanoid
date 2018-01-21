<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\PoolCommand, HumanoidMain as Plugin, command\SubCommand, task\PlayerTask, task\RemoveHumanoidTask, util\Translation
};

class CancelSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'cancel');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            $task = PlayerTask::getTask($sender);
            if ($task instanceof PlayerTask) {
                $task->cancel();
                $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
            }else{
                $sender->sendMessage(Plugin::$prefix . $this->translate('failure'));
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}