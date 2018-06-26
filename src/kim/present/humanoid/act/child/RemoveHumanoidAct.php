<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;

class RemoveHumanoidAct extends PlayerAct implements ClickHumanoidAct{
	/**
	 * @param PlayerClickHumanoidEvent $event
	 */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$event->getHumanoid()->kill();

		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-remove@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}