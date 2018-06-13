<?php

namespace kim\presenthumanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\item\Armor;
use pocketmine\item\ItemFactory;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\PlayerAct;
use kim\presenthumanoid\act\child\SetHumanoidArmorAct;
use kim\presenthumanoid\command\SimpleSubCommand;
use kim\presenthumanoid\util\Translation;

class SetArmorCommand extends SimpleSubCommand{

    public function __construct(){
        parent::__construct('armor');
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
                $item = $sender->getInventory()->getItemInHand();
            } else {
                $item = ItemFactory::fromString($args[0]);
                if ($item->isNull()) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-item', $args[0]));
                    return false;
                }
            }
            if ($item instanceof Armor) {
                PlayerAct::registerAct(new SetHumanoidArmorAct($sender, $item));
                return true;
            }else{
                $sender->sendMessage(Plugin::$prefix . Translation::translate('command-humanoid-set-armor@failure', $item->getName()));
                return false;
            }
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}