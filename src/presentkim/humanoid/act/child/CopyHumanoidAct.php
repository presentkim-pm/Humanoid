<?php

namespace presentkim\humanoid\act\child;

use presentkim\humanoid\Humanoid as Plugin;
use presentkim\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use presentkim\humanoid\event\PlayerClickHumanoidEvent;
use presentkim\humanoid\util\Translation;

class CopyHumanoidAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $this->cancel();
        PlayerAct::registerAct(new PasteHumanoidAct($this->player, clone $event->getHumanoid()->namedtag));

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-copy@success-copy'));

        $event->setCancelled(true);
    }
}