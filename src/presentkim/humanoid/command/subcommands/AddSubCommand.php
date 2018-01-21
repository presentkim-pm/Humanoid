<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\PoolCommand, HumanoidMain as Plugin, command\SubCommand, task\AddHumanoidTask, task\PlayerTask, util\Translation
};

class AddSubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'add');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            PlayerTask::registerTask(new AddHumanoidTask($sender, isset($args[0]) ? implode(' ', $args) : $sender->getNameTag()));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}