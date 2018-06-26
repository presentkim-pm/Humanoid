<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;

class StealHumanoidSkinAct extends PlayerAct implements ClickHumanoidAct{
	/**
	 * @param PlayerClickHumanoidEvent $event
	 */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$this->player->setSkin($event->getHumanoid()->getSkin());
		$this->player->sendSkin();

		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}