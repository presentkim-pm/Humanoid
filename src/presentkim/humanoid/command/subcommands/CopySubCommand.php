<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\CopyHumanoidAct;
use presentkim\humanoid\command\{
  SubCommand, PoolCommand,
};
use presentkim\humanoid\util\Translation;

class CopySubCommand extends SubCommand{

    public function __construct(PoolCommand $owner){
        parent::__construct($owner, 'copy');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new CopyHumanoidAct($sender));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}