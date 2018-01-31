<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use pocketmine\level\Position;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class SetHumanoidPositionAct extends PlayerAct implements ClickHumanoidAct{

    /** @var Position */
    private $pos;

    /**
     * @param Player   $player
     * @param Position $pos
     */
    public function __construct(Player $player, Position $pos){
        parent::__construct($player);
        $this->pos = $pos;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $event->getHumanoid()->teleport($this->pos);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-position@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}