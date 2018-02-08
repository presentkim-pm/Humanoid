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

class SetHumanoidSkinAct extends PlayerAct implements ClickHumanoidAct{

    /** @var Skin | null */
    private $skin;

    /**
     * @param Player    $player
     * @param Skin|null $skin
     */
    public function __construct(Player $player, Skin $skin = null){
        parent::__construct($player);
        $this->skin = $skin;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $humanoid = $event->getHumanoid();
        $humanoidSkin = $humanoid->getSkin();
        $humanoid->setSkin(new Skin('humanoid', $this->skin->getSkinData(), $humanoidSkin->getCapeData(), $humanoidSkin->getGeometryName()));
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-skin@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}