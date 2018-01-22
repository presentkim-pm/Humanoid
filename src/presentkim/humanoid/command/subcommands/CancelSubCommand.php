<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\PoolCommand, HumanoidMain as Plugin, command\SubCommand, act\PlayerAct, util\Translation
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
            $task = PlayerAct::getAct($sender);
            if ($task instanceof PlayerAct) {
                $task->cancel();
                $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
            } else {
                $sender->sendMessage(Plugin::$prefix . $this->translate('failure'));
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}