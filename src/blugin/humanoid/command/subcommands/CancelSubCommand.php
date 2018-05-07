<?php

namespace blugin\humanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\PlayerAct;
use blugin\humanoid\command\{
  SubCommand, PoolCommand
};
use blugin\humanoid\util\Translation;

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
    public function onCommand(CommandSender $sender, array $args) : bool{
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