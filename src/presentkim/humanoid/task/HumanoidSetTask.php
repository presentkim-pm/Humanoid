<?php

namespace presentkim\humanoid\task;

use pocketmine\event\player\PlayerInteractEvent;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;

abstract class HumanoidSetTask extends PlayerTask{

    /** @param PlayerClickHumanoidEvent $event */
    public abstract function onClickHumanoid(PlayerClickHumanoidEvent $event);

    /** @param PlayerInteractEvent $event */
    public function onInteract(PlayerInteractEvent $event){
    }
}