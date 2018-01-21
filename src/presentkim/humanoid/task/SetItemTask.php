<?php

namespace presentkim\humanoid\task;


use pocketmine\item\Item;
use pocketmine\Player;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class SetItemTask extends HumanoidSetTask{

    /** @var Item | null */
    private $item;

    public function __construct(Player $player, Item $item = null){
        parent::__construct($player);
        $this->item = $item;
    }

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $event->getHumanoid()->setHeldItem($this->item);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-item@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}