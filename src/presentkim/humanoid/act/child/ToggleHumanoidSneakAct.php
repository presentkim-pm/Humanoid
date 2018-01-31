<?php

namespace presentkim\humanoid\act\child;

use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class ToggleHumanoidSneakAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $humanoid = $event->getHumanoid();
        $humanoid->setSneaking(!$humanoid->isSneaking());
        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set-sneak@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}