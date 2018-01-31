<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\PlayerAct;
use presentkim\humanoid\act\child\SetHumanoidItemAct;
use presentkim\humanoid\command\SimpleSubCommand;
use presentkim\humanoid\util\{
  Translation, Utils
};

class SetItemCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('item');
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
                    $item = $sender->getInventory()->getItemInHand();
                } else {
                    $id = Utils::toInt($args[0], null, function (int $i){
                        return $i >= 0;
                    });
                    $damage = isset($args[1]) ? Utils::toInt($args[1], 0, function (int $i){
                        return $i >= 0;
                    }) : 0;
                    if ($id === null) {
                        $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid', $args[0]));
                        return false;
                    } else {
                        $item = Item::get($id, $damage);
                    }
                }
                PlayerAct::registerAct(new SetHumanoidItemAct($sender, $item));
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