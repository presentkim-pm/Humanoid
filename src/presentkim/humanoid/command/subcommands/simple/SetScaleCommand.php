<?php

namespace presentkim\humanoid\command\subcommands\simple;


use function is_numeric;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\task\{
  PlayerTask, HumanoidSetTask
};

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
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                $scale = is_numeric($args[0]) ? (float) $args[0] : null;
                if ($scale === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                    return false;
                } else {
                    PlayerTask::registerTask(new class($sender, $scale) extends HumanoidSetTask{

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
                        public function onClickHumanoid(PlayerClickHumanoidEvent $event){
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