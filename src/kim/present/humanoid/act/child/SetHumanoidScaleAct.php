<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\Player;

class SetHumanoidScaleAct extends PlayerAct implements ClickHumanoidAct{
	/**
	 * @var int
	 */
	private $scale;

	/**
	 * @param Player $player
	 * @param  int   $scale
	 */
	public function __construct(Player $player, int $scale){
		parent::__construct($player);
		$this->scale = $scale;
	}

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$event->getHumanoid()->setScale($this->scale * 0.01);
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}