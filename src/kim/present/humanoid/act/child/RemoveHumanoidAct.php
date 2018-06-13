<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;

class RemoveHumanoidAct extends PlayerAct implements ClickHumanoidAct{

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$event->getHumanoid()->kill();

		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-remove@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}