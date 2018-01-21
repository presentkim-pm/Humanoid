<?php

namespace presentkim\humanoid\task;


use pocketmine\entity\Skin;
use pocketmine\Player;
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class SetSkinTask extends HumanoidSetTask{

    /** @var Skin | null */
    private $skin;

    public function __construct(Player $player, Skin $skin = null){
        parent::__construct($player);
        $this->skin = $skin;
    }

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $event->getHumanoid()->setSkin($this->skin);
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-skin@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}