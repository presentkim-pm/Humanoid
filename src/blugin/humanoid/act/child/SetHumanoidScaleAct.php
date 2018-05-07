<?php

namespace blugin\humanoid\act\child;

use pocketmine\Player;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

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
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}