<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class SetSneakCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('sneak');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            PlayerAct::registerAct(new class($sender, implode(' ', $args)) extends PlayerAct implements ClickHumanoidAct{

                /** @var string */
                private $name;

                /**
                 * @param Player $player
                 * @param string $name
                 */
                public function __construct(Player $player, string $name){
                    parent::__construct($player);
                    $this->name = $name;
                }

                /** @param PlayerClickHumanoidEvent $event */
                public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                    $humanoid = $event->getHumanoid();
                    $humanoid->setSneaking(!$humanoid->isSneaking());
                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-sneak@success'));

                    $event->setCancelled(true);
                    $this->cancel();
                }
            });
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}