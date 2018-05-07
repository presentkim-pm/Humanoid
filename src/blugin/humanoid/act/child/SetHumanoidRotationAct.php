<?php

namespace blugin\humanoid\act\child;

use pocketmine\Player;
use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

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