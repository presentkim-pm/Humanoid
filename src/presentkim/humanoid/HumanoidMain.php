<?php

namespace presentkim\humanoid;

use pocketmine\plugin\PluginBase;
use presentkim\humanoid\listener\PlayerEventListener;

class HumanoidMain extends PluginBase{

    /** @var self */
    private static $instance = null;

    /** @return self */
    public static function getInstance(){
        return self::$instance;
    }

    public function onLoad(){
        if (self::$instance === null) {
            self::$instance = $this;
            $this->getServer()->getLoader()->loadClass('presentkim\humanoid\util\Utils');
        }
    }

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);
    }
}
