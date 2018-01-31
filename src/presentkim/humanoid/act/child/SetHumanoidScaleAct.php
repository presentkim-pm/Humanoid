<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class SetHumanoidScaleAct extends PlayerAct implements ClickHumanoidAct{

    /** @var int */
    private $scale;

    /**
     * @param Player $player
     * @param  int   $scale
     */
    public function __construct(Player $player, int $scale){
        parent::__construct($player);
        $this->scale = $scale;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $event->getHumanoid()->setScale($this->scale * 0.01);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-scale@success', $this->scale));

        $event->setCancelled(true);
        $this->cancel();
    }
}