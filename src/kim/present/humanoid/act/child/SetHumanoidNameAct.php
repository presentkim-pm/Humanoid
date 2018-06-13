<?php

namespace kim\presenthumanoid\act\child;

use pocketmine\Player;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\util\Translation;

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