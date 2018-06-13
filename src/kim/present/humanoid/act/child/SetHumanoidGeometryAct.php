<?php

namespace kim\presenthumanoid\act\child;

use kim\presenthumanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\presenthumanoid\event\PlayerClickHumanoidEvent;
use kim\presenthumanoid\Humanoid as Plugin;
use kim\presenthumanoid\util\Translation;
use pocketmine\entity\Skin;
use pocketmine\Player;

class SetHumanoidGeometryAct extends PlayerAct implements ClickHumanoidAct{

	/** @var string */
	private $geometryName;

	/**
	 * @param Player $player
	 * @param string $geometryName
	 */
	public function __construct(Player $player, string $geometryName){
		parent::__construct($player);
		$this->geometryName = $geometryName;
	}

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$humanoid = $event->getHumanoid();
		$humanoidSkin = $humanoid->getSkin();
		$humanoid->setSkin(new Skin('humanoid', $humanoidSkin->getSkinData(), $humanoidSkin->getCapeData(), $this->geometryName));
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}