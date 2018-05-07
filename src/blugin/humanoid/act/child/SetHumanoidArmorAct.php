<?php

namespace blugin\humanoid\act\child;

use pocketmine\Player;
use pocketmine\item\Item;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\inventory\HumanoidInventory;
use blugin\humanoid\util\Translation;

class SetHumanoidArmorAct extends PlayerAct implements ClickHumanoidAct{

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
        $humanoid = $event->getHumanoid();
        $inventory = $humanoid->getInventory();
        $index = $inventory->getIndex($this->item);
        if ($index === HumanoidInventory::HELDITEM) {
            $this->player->sendMessage(Plugin::$prefix . Translation::translate('command-humanoid-set-armor@failure', $this->item->getName()));
        } else {
            $armor = $inventory->getItem($index);
            if ($armor->equals($this->item, true, true)) {
                $inventory->clear($index);
            } else {
                $inventory->setItem($index, $this->item);
            }
            $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));
        }

        $event->setCancelled(true);
        $this->cancel();
    }
}