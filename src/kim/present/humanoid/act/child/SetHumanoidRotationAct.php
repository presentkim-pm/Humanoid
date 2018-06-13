<?php

namespace kim\presenthumanoid\act\child;

use pocketmine\Player;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\util\Translation;

class SetHumanoidRotationAct extends PlayerAct implements ClickHumanoidAct{

    /** @var int | null */
    private $yaw;

    /** @var int | null */
    private $pitch;

    /**
     * @param Player   $player
     * @param int|null $yaw
     * @param int|null $pitch
     */
    public function __construct(Player $player, ?int $yaw = null, ?int $pitch = null){
        parent::__construct($player);
        $this->yaw = $yaw;
        $this->pitch = $pitch;
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $this->yaw = $this->yaw ?? $this->player->yaw;
        $this->pitch = $this->pitch ?? $this->player->pitch;
        $event->getHumanoid()->setRotation($this->yaw, $this->pitch);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}