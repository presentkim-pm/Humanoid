<?php

namespace presentkim\humanoid\task;


use pocketmine\entity\Skin;
use pocketmine\Player;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class SetGeometryTask extends HumanoidSetTask{

    /** @var string */
    private $geometryName;

    public function __construct(Player $player, string $geometryName){
        parent::__construct($player);
        $this->geometryName = $geometryName;
    }

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $event->getHumanoid()->setSkin(new Skin('humanoid', $event->getHumanoid()->getSkin()->getSkinData(), '', $this->geometryName));
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-geometry@success', $this->geometryName));

        $event->setCancelled(true);
        $this->cancel();
    }
}