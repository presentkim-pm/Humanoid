<?php

namespace presentkim\humanoid\task;


use pocketmine\Player;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class SetRotationTask extends HumanoidSetTask{

    /** @var int | null */
    private $yaw;

    /** @var int | null */
    private $pitch;

    public function __construct(Player $player, ?int $yaw = null, ?int $pitch = null){
        parent::__construct($player);
        $this->yaw = $yaw;
        $this->pitch = $pitch;
    }

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $this->yaw = $this->yaw ?? $this->player->yaw;
        $this->pitch = $this->pitch ?? $this->player->pitch;
        $event->getHumanoid()->setRotation($this->yaw, $this->pitch);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-rotation@success', $this->yaw, $this->pitch));

        $event->setCancelled(true);
        $this->cancel();
    }
}