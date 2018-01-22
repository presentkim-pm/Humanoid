<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, player\PlayerInteractEvent
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\task\{
  PlayerAct, HumanoidSetAct
};

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onPlayerClickHumanoidEvent(PlayerClickHumanoidEvent $event){
        $task = PlayerAct::getTask($player = $event->getPlayer());
        if ($task instanceof HumanoidSetAct) {
            $task->onClickHumanoid($event);
        }
    }

    /** @param PlayerInteractEvent $event */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        $task = PlayerAct::getTask($player = $event->getPlayer());
        if ($task instanceof PlayerAct) {
            $task->onInteract($event);
        }
    }
}