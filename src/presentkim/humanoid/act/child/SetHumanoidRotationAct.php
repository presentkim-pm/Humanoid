<?php

namespace presentkim\humanoid\act\child;

use pocketmine\Player;
use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

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
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-rotation@success', $this->yaw, $this->pitch));

        $event->setCancelled(true);
        $this->cancel();
    }
}