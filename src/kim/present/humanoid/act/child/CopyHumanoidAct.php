<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;

class CopyHumanoidAct extends PlayerAct implements ClickHumanoidAct{
	/**
	 * @param PlayerClickHumanoidEvent $event
	 */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$this->cancel();
		$humanoid = $event->getHumanoid();
		$humanoid->saveNBT();
		PlayerAct::registerAct(new PasteHumanoidAct($this->player, clone $humanoid->namedtag));

		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-copy@success-copy'));

		$event->setCancelled(true);
	}
}