<?php

namespace kim\presenthumanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\act\child\SetHumanoidCapeAct;
use kim\presenthumanoid\command\SimpleSubCommand;
use kim\presenthumanoid\util\Translation;

class SetCapeCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('cape');
    }

    /**
     * @param CommandSender $sender
     * @param String[]      $args
     *
     * @return bool
     */
    public function onCommand(CommandSender $sender, array $args) : bool{
        if ($sender instanceof Player) {
            if (!isset($args[0]) || $args[0] === '*') {
                $skin = $sender->getSkin();
            } else {
                $player = Server::getInstance()->getPlayer($args[0]);
                if ($player === null) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-player', $args[0]));
                    return false;
                } else {
                    $skin = $player->getSkin();
                }
            }
            PlayerAct::registerAct(new SetHumanoidCapeAct($sender, $skin));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}