<?php

namespace presentkim\humanoid\act\child;

use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class StealHumanoidSkinAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $this->player->setSkin($event->getHumanoid()->getSkin());

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-skinsteal@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}