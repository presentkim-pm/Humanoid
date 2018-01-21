<?php

namespace presentkim\humanoid\task;


use pocketmine\Player;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class SetNameTask extends HumanoidSetTask{

    /** @var string */
    private $name;

    public function __construct(Player $player, string $name){
        parent::__construct($player);
        $this->name = $name;
    }

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $event->getHumanoid()->setNameTag($this->name);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-name@success', $this->name));

        $event->setCancelled(true);
        $this->cancel();
    }
}