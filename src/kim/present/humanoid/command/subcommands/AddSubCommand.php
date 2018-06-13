<?php

namespace kim\presenthumanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\act\child\AddHumanoidAct;
use kim\presenthumanoid\command\{
  SubCommand, PoolCommand
};
use kim\presenthumanoid\util\Translation;

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
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new AddHumanoidAct($sender, isset($args[0]) ? implode(' ', $args) : $sender->getNameTag()));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}