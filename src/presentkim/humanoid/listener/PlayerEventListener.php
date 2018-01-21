<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, player\PlayerInteractEvent
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\task\{
  PlayerTask, HumanoidSetTask
};

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerClickHumanoidEvent $event */
    public function onPlayerClickHumanoidEvent(PlayerClickHumanoidEvent $event){
        $task = PlayerTask::getTask($player = $event->getPlayer());
        if ($task instanceof HumanoidSetTask) {
            $task->onClickHumanoid($event);
        }
    }

    /** @param PlayerInteractEvent $event */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        $task = PlayerTask::getTask($player = $event->getPlayer());
        if ($task instanceof PlayerTask) {
            $task->onInteract($event);
        }
    }
}