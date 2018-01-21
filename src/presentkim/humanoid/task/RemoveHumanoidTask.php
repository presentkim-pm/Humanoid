<?php

namespace presentkim\humanoid\task;


use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\HumanoidMain as Plugin;
use presentkim\humanoid\util\Translation;

class RemoveHumanoidTask extends HumanoidSetTask{

    public function onClickHumanoid(PlayerClickHumanoidEvent $event){
        $event->getHumanoid()->kill();

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-remove@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}