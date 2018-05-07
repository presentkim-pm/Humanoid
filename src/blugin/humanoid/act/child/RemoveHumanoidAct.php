<?php

namespace blugin\humanoid\act\child;

use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

class RemoveHumanoidAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $event->getHumanoid()->kill();

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-remove@success'));

        $event->setCancelled(true);
        $this->cancel();
    }
}