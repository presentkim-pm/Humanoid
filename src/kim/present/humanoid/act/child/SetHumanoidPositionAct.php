<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;
use pocketmine\level\Position;
use pocketmine\Player;

class SetHumanoidPositionAct extends PlayerAct implements ClickHumanoidAct{

	/** @var Position */
	private $pos;

	/**
	 * @param Player   $player
	 * @param Position $pos
	 */
	public function __construct(Player $player, Position $pos){
		parent::__construct($player);
		$this->pos = $pos;
	}

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$event->getHumanoid()->teleport($this->pos);
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}