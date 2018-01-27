<?php

namespace presentkim\humanoid\command\subcommands\simple;

use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use presentkim\humanoid\{
  command\SimpleSubCommand, HumanoidMain as Plugin, event\PlayerClickHumanoidEvent, util\Translation
};
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use function presentkim\humanoid\util\toInt;

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
                        $item = Item::get($id, $damage);

                    }
                }
                PlayerAct::registerAct(new class ($sender, $item) extends PlayerAct implements ClickHumanoidAct{

                    /** @var Item | null */
                    private $item;

                    /**
                     * @param Player    $player
                     * @param Item|null $item
                     */
                    public function __construct(Player $player, Item $item = null){
                        parent::__construct($player);
                        $this->item = $item;
                    }

                    /** @param PlayerClickHumanoidEvent $event */
                    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
                        $event->getHumanoid()->setHeldItem($this->item);
                        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-item@success'));

                        $event->setCancelled(true);
                        $this->cancel();
                    }
                });
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