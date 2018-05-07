<?php

namespace blugin\humanoid\act\child;

use pocketmine\Player;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

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