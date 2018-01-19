<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, player\PlayerInteractEvent
};
use presentkim\humanoid\HumanoidMain as Plugin;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param PlayerInteractEvent $event */
    public function onPlayerInteractEvent(PlayerInteractEvent $event){

    }
}