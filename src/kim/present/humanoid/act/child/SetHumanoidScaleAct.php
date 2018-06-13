<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;
use pocketmine\Player;

class SetHumanoidScaleAct extends PlayerAct implements ClickHumanoidAct{

	/** @var int */
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