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

class SetHumanoidCapeAct extends PlayerAct implements ClickHumanoidAct{

	/** @var Skin | null */
	private $skin;

	/**
	 * @param Player    $player
	 * @param Skin|null $skin
	 */
	public function __construct(Player $player, Skin $skin = null){
		parent::__construct($player);
		$this->skin = $skin;
	}

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$humanoid = $event->getHumanoid();
		$humanoidSkin = $humanoid->getSkin();
		$humanoid->setSkin(new Skin('humanoid', $humanoidSkin->getSkinData(), $this->skin->getCapeData(), $humanoidSkin->getGeometryName()));
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}