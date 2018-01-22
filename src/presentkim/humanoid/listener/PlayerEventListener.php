<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, player\PlayerInteractEvent
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct, InteractAct
};

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onPlayerClickHumanoidEvent(PlayerClickHumanoidEvent $event){
        $task = PlayerAct::getAct($player = $event->getPlayer());
        if ($task instanceof ClickHumanoidAct) {
            $task->onClickHumanoid($event);
        }
    }

    /** @param PlayerInteractEvent $event */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        $task = PlayerAct::getAct($player = $event->getPlayer());
        if ($task instanceof InteractAct) {
            $task->onInteract($event);
        }
    }
}