<?php

namespace kim\present\humanoid\listener;

use kim\present\humanoid\act\{
	ClickHumanoidAct, InteractAct, PlayerAct
};
use kim\present\humanoid\event\PlayerClickHumanoidEvent;
use kim\present\humanoid\Humanoid as Plugin;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class PlayerEventListener implements Listener{
	/** @var Plugin */
	private $owner = null;

	/**
	 * PlayerEventListener constructor.
	 */
	public function __construct(){
		$this->owner = Plugin::getInstance();
	}

	/**
	 * @priority LOW
	 *
	 * @param PlayerClickHumanoidEvent $event
	 */
	public function onPlayerClickHumanoidEvent(PlayerClickHumanoidEvent $event) : void{
		if(!$event->isCancelled()){
			$task = PlayerAct::getAct($player = $event->getPlayer());
			if($task instanceof ClickHumanoidAct){
				$task->onClickHumanoid($event);
			}
		}
	}

	/**
	 * @priority LOW
	 *
	 * @param PlayerInteractEvent $event
	 */
	public function onPlayerInteractEvent(PlayerInteractEvent $event) : void{
		if(!$event->isCancelled()){
			$task = PlayerAct::getAct($player = $event->getPlayer());
			if($task instanceof InteractAct){
				$task->onInteract($event);
			}
		}
	}
}