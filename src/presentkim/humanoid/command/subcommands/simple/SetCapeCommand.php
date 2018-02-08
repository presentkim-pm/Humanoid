<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\SetHumanoidCapeAct;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\util\Translation;

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
                $player = Server::getInstance()->getPlayerExact($args[0]);
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