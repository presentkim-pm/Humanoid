<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\command\CommandSender;
use pocketmine\entity\Skin;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};

class SetGeometryCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('geometry');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    $args[0] = $sender->getSkin()->getGeometryName();
                }
                PlayerAct::registerAct(new class($sender, implode('_', $args)) extends PlayerAct implements ClickHumanoidAct{

                    /** @var string */
                    private $geometryName;

                    /**
                     * @param Player $player
                     * @param string $geometryName
                     */
                    public function __construct(Player $player, string $geometryName){
                        parent::__construct($player);
                        $this->geometryName = $geometryName;
                    }

                    /** @param PlayerClickHumanoidEvent $event */
                    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                        $event->getHumanoid()->setSkin(new Skin('humanoid', $event->getHumanoid()->getSkin()->getSkinData(), '', $this->geometryName));
                        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-geometry@success', $this->geometryName));

                        $event->setCancelled(true);
                        $this->cancel();
                    }
                });
                return true;
            } else {
                $sender->sendMessage(Plugin::$prefix . $this->usage);
                return false;
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}