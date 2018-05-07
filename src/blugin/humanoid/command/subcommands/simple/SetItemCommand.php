<?php

namespace blugin\humanoid\command\subcommands\simple;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\PlayerAct;
use blugin\humanoid\act\child\SetHumanoidItemAct;
use blugin\humanoid\command\SimpleSubCommand;
use blugin\humanoid\util\Translation;

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
            if (!isset($args[0]) || $args[0] === '*') {
                $item = $sender->getInventory()->getItemInHand();
            } else {
                $item = ItemFactory::fromString($args[0]);
                if ($item->isNull()) {
                    $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@invalid-item', $args[0]));
                    return false;
                }
            }
            PlayerAct::registerAct(new SetHumanoidItemAct($sender, $item));
            return true;
        } else {
            $sender->sendMessage(Plugin::$prefix . Translation::translate('command-generic-failure@in-game'));
            return false;
        }
    }
}