<?php

namespace presentkim\humanoid\listener;

use pocketmine\event\{
  Listener, server\DataPacketReceiveEvent
};
use presentkim\humanoid\HumanoidMain as Plugin;

class PlayerEventListener implements Listener{

    /** @var Plugin */
    private $owner = null;

    public function __construct(){
        $this->owner = Plugin::getInstance();
    }

    /** @param DataPacketReceiveEvent $event */
    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $event){
        
    }
}