<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\command\{
  SubCommand, PoolCommand,
};
use presentkim\humanoid\{
  HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\task\{
  PlayerTask, HumanoidSetTask
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
            PlayerTask::registerTask(new class ($sender) extends HumanoidSetTask{

                public function onClickHumanoid(PlayerClickHumanoidEvent $event){
                    $event->getHumanoid()->kill();

                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-remove@success'));

                    $event->setCancelled(true);
                    $this->cancel();
                }
            });
            $sender->sendMessage(Plugin::$prefix . $this->translate('success'));
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
        }
        return true;
    }
}