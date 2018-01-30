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

use function presentkim\humanoid\util\toInt;

class SetScaleCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('scale');
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
                $scale = toInt($args[0], null, function (int $i){
                    return $i >= 10;
                });
                if ($scale === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                    return false;
                } else {
                    PlayerAct::registerAct(new class($sender, $scale) extends PlayerAct implements ClickHumanoidAct{

                        /** @var int */
                        private $scale;

                        /**
                         * @param Player $player
                         * @param  int   $scale
                         */
                        public function __construct(Player $player, int $scale){
                            parent::__construct($player);
                            $this->scale = $scale;
                        }

                        /** @param PlayerClickHumanoidEvent $event */
                        public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                            $event->getHumanoid()->setScale($this->scale * 0.01);
                            $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-scale@success', $this->scale));

                            $event->setCancelled(true);
                            $this->cancel();
                        }
                    });
                    return true;
                }
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