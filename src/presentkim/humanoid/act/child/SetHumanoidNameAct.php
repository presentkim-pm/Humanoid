<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class SetHumanoidNameAct extends PlayerAct implements ClickHumanoidAct{

    /** @var string */
    private $name;

    /**
     * @param Player $player
     * @param string $name
     */
    public function __construct(Player $player, string $name){
        parent::__construct($player);
        $this->name = $name;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $event->getHumanoid()->setNameTag($this->name);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}