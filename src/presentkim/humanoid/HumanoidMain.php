<?php

namespace presentkim\humanoid;

use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use presentkim\humanoid\listener\PlayerEventListener;
use presentkim\humanoid\entity\Humanoid;
use presentkim\humanoid\util\Translation;

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
            Translation::loadFromResource($this->getResource('lang/eng.yml'), true);

            Entity::registerEntity(Humanoid::class, true, ['Humanoid', 'presentkim:humanoid']);
        }
    }

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener(), $this);
    }
}
