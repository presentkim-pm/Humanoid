<?php

namespace blugin\humanoid\act\child;

use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

class StealHumanoidSkinAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $this->player->setSkin($event->getHumanoid()->getSkin());
        $this->player->sendSkin();

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}