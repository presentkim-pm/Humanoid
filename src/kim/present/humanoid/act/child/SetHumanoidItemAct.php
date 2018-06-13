<?php

namespace kim\present\humanoid\act\child;

use kim\present\humanoid\act\{
	ClickHumanoidAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use kim\present\humanoid\util\Translation;
use pocketmine\item\Item;
use pocketmine\Player;

class SetHumanoidItemAct extends PlayerAct implements ClickHumanoidAct{

	/** @var Item | null */
	private $item;

	/**
	 * @param Player    $player
	 * @param Item|null $item
	 */
	public function __construct(Player $player, Item $item = null){
		parent::__construct($player);
		$this->item = $item;
	}

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void{
		$event->getHumanoid()->getInventory()->setHeldItem($this->item);
		$this->player->sendMessage(Plugin::$prefix . Translation::translate('humanoid-set@success'));

		$event->setCancelled(true);
		$this->cancel();
	}
}