<?php

namespace blugin\humanoid\act\child;

use pocketmine\Player;
use pocketmine\entity\Skin;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

class SetHumanoidGeometryAct extends PlayerAct implements ClickHumanoidAct{

    /** @var string */
    private $geometryName;

    /**
     * @param Player $player
     * @param string $geometryName
     */
    public function __construct(Player $player, string $geometryName){
        parent::__construct($player);
        $this->geometryName = $geometryName;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $humanoid = $event->getHumanoid();
        $humanoidSkin = $humanoid->getSkin();
        $humanoid->setSkin(new Skin('humanoid', $humanoidSkin->getSkinData(), $humanoidSkin->getCapeData(), $this->geometryName));
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}