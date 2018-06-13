<?php

namespace kim\present\humanoid\act;

use pocketmine\Player;

abstract class PlayerAct{

	/** @var PlayerAct[] */
	private static $acts = [];
	/** @var Player */
	protected $player;
	/** @var int */
	protected $id;

	/** @param \pocketmine\Player $player */
	public function __construct(Player $player){
		$this->player = $player;
	}

	/** @return PlayerAct[] */
	public static function getActs() : array{
		return PlayerAct::$acts;
	}

	/**
	 * @param Player $player
	 *
	 * @return PlayerAct | null
	 */
	public static function getAct(Player $player) : ?PlayerAct{
		return PlayerAct::$acts[$player->getLowerCaseName()] ?? null;
	}

	public static function cancelAllAct() : void{
		PlayerAct::$acts = [];
	}

	public function register() : void{
		self::registerAct($this);
	}

	/** @param PlayerAct $task */
	public static function registerAct(PlayerAct $task) : void{
		PlayerAct::$acts[$task->getKey()] = $task;
	}

	/** @return string */
	public function getKey() : string{
		return $this->player->getLowerCaseName();
	}

	public function cancel() : void{
		self::cancelAct($this);
	}

	/** @param PlayerAct $task */
	public static function cancelAct(PlayerAct $task) : void{
		unset(PlayerAct::$acts[$task->getKey()]);
	}
}