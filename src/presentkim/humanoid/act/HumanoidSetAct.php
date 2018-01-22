<?php

namespace presentkim\humanoid\act;

use pocketmine\event\player\PlayerInteractEvent;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;

abstract class HumanoidSetAct extends PlayerAct{

    /** @param PlayerClickHumanoidEvent $event */
    public abstract function onClickHumanoid(PlayerClickHumanoidEvent $event);

    /** @param PlayerInteractEvent $event */
    public function onInteract(PlayerInteractEvent $event){
    }
}