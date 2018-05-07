<?php

namespace blugin\humanoid\act\child;

use blugin\humanoid\Humanoid as Plugin;
use blugin\humanoid\act\{
  PlayerAct, ClickHumanoidAct
};
use blugin\humanoid\event\PlayerClickHumanoidEvent;
use blugin\humanoid\util\Translation;

class CopyHumanoidAct extends PlayerAct implements ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
        $this->cancel();
        $humanoid = $event->getHumanoid();
        $humanoid->saveNBT();
        PlayerAct::registerAct(new PasteHumanoidAct($this->player, clone $humanoid->namedtag));

        $this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-copy@success-copy'));

        $event->setCancelled(true);
    }
}