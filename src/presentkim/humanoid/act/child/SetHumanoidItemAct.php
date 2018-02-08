<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use pocketmine\item\Item;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class SetHumanoidItemAct extends PlayerAct implements ClickHumanoidAct{

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
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}