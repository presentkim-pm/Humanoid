<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\SetHumanoidSkinAct;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\util\Translation;

class SetSkinCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('skin');
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
            } else {
                $skin = $sender->getSkin();
            }
            PlayerAct::registerAct(new SetHumanoidSkinAct($sender, $skin));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}