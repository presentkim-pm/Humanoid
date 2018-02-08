<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use pocketmine\entity\Skin;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

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
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-geometry@success', $this->geometryName));

        $event->setCancelled(true);
        $this->cancel();
    }
}