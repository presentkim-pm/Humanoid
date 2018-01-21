<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, task\PlayerTask, task\SetItemTask, task\SetSkinTask, util\Translation
};
use function presentkim\humanoid\util\toInt;

class SetSkinCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('skin');
    }

    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    PlayerTask::registerTask(new SetSkinTask($sender, $sender->getSkin()));
                    return true;
                } else {
                    $player = Server::getInstance()->getPlayerExact($args[0]);
                    if ($player === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-player', $args[0]));
                        return false;
                    } else {
                        PlayerTask::registerTask(new SetSkinTask($sender, $player->getSkin()));
                        return true;
                    }
                }
            } else {
                PlayerTask::registerTask(new SetSkinTask($sender, $sender->getSkin()));
                return true;
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}