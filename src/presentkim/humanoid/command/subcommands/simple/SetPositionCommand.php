<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};

class SetPositionCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('position');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (!isset($args[0])) {
                $pos = $sender->asPosition();
            } elseif (isset($args[0]) && !isset($args[1])) {
                if ($args === '*') {
                    $pos = $sender->asPosition();
                } else {
                    $player = Server::getInstance()->getPlayerExact($args[0]);
                    if ($player === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-player', $args[0]));
                        return false;
                    } else {
                        $pos = $player->asPosition();
                    }
                }
            } elseif (isset($args[2])) {
                $x = is_numeric($args[0]) ? (float) $args[0] : null;
                if ($x === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                    return false;
                }
                $y = is_numeric($args[1]) ? (float) $args[1] : null;
                if ($y === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[1]));
                    return false;
                }
                $z = is_numeric($args[2]) ? (float) $args[2] : null;
                if ($z === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[2]));
                    return false;
                }
                if (isset($args[3])) {
                    $level = Server::getInstance()->getLevelByName($args[3]);
                    if ($level === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[3]));
                        return false;
                    }
                } else {
                    $level = $sender->getLevel();
                }
                $pos = new Position($x, $y, $z, $level);
            } else {
                $sender->sendMessage(Plugin::$prefix . $this->usage);
                return false;
            }
            PlayerAct::registerTask(new class($sender, $pos) extends PlayerAct implements ClickHumanoidAct{

                /** @var Vector3 */
                private $pos;

                /**
                 * @param Player  $player
                 * @param Vector3 $pos
                 */
                public function __construct(Player $player, Vector3 $pos){
                    parent::__construct($player);
                    $this->pos = $pos;
                }

                /** @param PlayerClickHumanoidEvent $event */
                public function onClickHumanoid(PlayerClickHumanoidEvent $event){
                    $event->getHumanoid()->teleport($this->pos);
                    $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-position@success'));

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