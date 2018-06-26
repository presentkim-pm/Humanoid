<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\level\Position;
use pocketmine\Player;

class SetHumanoidPositionAct extends PlayerAct implements ClickHumanoidAct{
	/**
	 * @var Position
	 */
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