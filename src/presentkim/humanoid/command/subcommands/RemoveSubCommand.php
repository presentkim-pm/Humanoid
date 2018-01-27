<?php

namespace presentkim\humanoid\command\subcommands;

use pocketmine\Player;
use pocketmine\command\CommandSender;

use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\command\{
  SubCommand, PoolCommand,
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

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
            PlayerAct::registerAct(new class ($sender) extends PlayerAct implements ClickHumanoidAct{

                /** @param PlayerClickHumanoidEvent $event */
                public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
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