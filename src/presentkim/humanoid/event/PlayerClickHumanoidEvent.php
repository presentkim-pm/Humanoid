<?php

namespace presentkim\humanoid\event;

use pocketmine\event\{
  Cancellable, player\PlayerEvent
};
use pocketmine\Player;
use presentkim\humanoid\entity\Humanoid;

class PlayerClickHumanoidEvent extends PlayerEvent implements Cancellable{

    public static $handlerList = null;

    public const LEFT_CLICK = 0;

    public const RIGHT_CLICK = 1;

    /** @var Humanoid */
    protected $humanoid;

    /** @var int */
    protected $action;


    public function __construct(Player $player, Humanoid $humanoid, int $action = self::LEFT_CLICK){
        $this->player = $player;
        $this->humanoid = $humanoid;
        $this->action = $action;
    }

    /** @return Humanoid */
    public function getHumanoid(){
        return $this->humanoid;
    }

    /** @return int */
    public function getAction() : int{
        return $this->action;
    }
}