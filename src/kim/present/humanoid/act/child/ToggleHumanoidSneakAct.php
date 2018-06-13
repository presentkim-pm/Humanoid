<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;

class ToggleHumanoidSneakAct extends PlayerAct implements ClickHumanoidAct{

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$humanoid = $event->getHumanoid();
		$humanoid->setSneaking(!$humanoid->isSneaking());
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}