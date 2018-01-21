<?php

namespace presentkim\humanoid\command\subcommands\simple;


use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, task\PlayerTask, task\SetItemTask, util\Translation
};
use function presentkim\humanoid\util\toInt;

class SetItemCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('item');
    }

    public function onCommand(CommandSender $sender, array $args){
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($args[0] === '*') {
                    PlayerTask::registerTask(new SetItemTask($sender, $sender->getInventory()->getItemInHand()));
                    return true;
                } else {
                    $id = toInt($args[0], null, function (int $i){
                        return $i >= 0;
                    });
                    $damage = isset($args[1]) ? toInt($args[1], 0, function (int $i){
                        return $i >= 0;
                    }) : 0;
                    if ($id === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                        return false;
                    } else {
                        PlayerTask::registerTask(new SetItemTask($sender, Item::get($id, $damage)));
                        return true;
                    }
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