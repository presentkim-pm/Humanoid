<?php

namespace blugin\humanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\PlayerAct;
use blugin\humanoid\act\child\RemoveHumanoidAct;
use blugin\humanoid\command\{
  SubCommand, PoolCommand
};
use blugin\humanoid\util\Translation;

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
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new RemoveHumanoidAct($sender));
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}