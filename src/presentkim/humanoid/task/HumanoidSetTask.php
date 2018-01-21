<?php

namespace presentkim\humanoid\task;

use pocketmine\event\player\PlayerInteractEvent;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;

abstract class HumanoidSetTask extends PlayerTask{

    public abstract function onClickHumanoid(PlayerClickHumanoidEvent $event);

    public function onInteract(PlayerInteractEvent $event){
    }
}