<?php

namespace kim\presenthumanoid\act;

use pocketmine\Player;

abstract class PlayerAct{

    /** @var PlayerAct[] */
    private static $acts = [];

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

    /** @param PlayerAct $task */
    public static function registerAct(PlayerAct $task) : void{
        PlayerAct::$acts[$task->getKey()] = $task;
    }

    /** @param PlayerAct $task */
    public static function cancelAct(PlayerAct $task) : void{
        unset(PlayerAct::$acts[$task->getKey()]);
    }

    public static function cancelAllAct() : void{
        PlayerAct::$acts = [];
    }

    /** @var Player */
    protected $player;

    /** @var int */
    protected $id;

    /** @param \pocketmine\Player $player */
    public function __construct(Player $player){
        $this->player = $player;
    }

    public function register() : void{
        self::registerAct($this);
    }

    public function cancel() : void{
        self::cancelAct($this);
    }

    /** @return string */
    public function getKey() : string{
        return $this->player->getLowerCaseName();
    }
}