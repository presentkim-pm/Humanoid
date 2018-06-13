<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;

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