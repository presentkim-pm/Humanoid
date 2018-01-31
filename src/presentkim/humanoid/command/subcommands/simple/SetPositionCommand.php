<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\SetHumanoidPositionAct;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\util\Translation;

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
    public function onCommand(CommandSender $sender, array $args) : bool{
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
            PlayerAct::registerAct(new SetHumanoidPositionAct($sender, $pos));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}